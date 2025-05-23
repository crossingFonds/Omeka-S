<?php declare(strict_types=1);

/*
 * Copyright 2015-2023 Daniel Berthereau
 * Copyright 2016-2017 BibLibre
 *
 * This software is governed by the CeCILL license under French law and abiding
 * by the rules of distribution of free software. You can use, modify and/or
 * redistribute the software under the terms of the CeCILL license as circulated
 * by CEA, CNRS and INRIA at the following URL "http://www.cecill.info".
 *
 * As a counterpart to the access to the source code and rights to copy, modify
 * and redistribute granted by the license, users are provided only with a
 * limited warranty and the software’s author, the holder of the economic
 * rights, and the successive licensors have only limited liability.
 *
 * In this respect, the user’s attention is drawn to the risks associated with
 * loading, using, modifying and/or developing or reproducing the software by
 * the user in light of its specific status of free software, that may mean that
 * it is complicated to manipulate, and that also therefore means that it is
 * reserved for developers and experienced professionals having in-depth
 * computer knowledge. Users are therefore encouraged to load and test the
 * software’s suitability as regards their requirements in conditions enabling
 * the security of their systems and/or data to be ensured and, more generally,
 * to use and operate it in the same conditions as regards security.
 *
 * The fact that you are presently reading this means that you have had
 * knowledge of the CeCILL license and that you accept its terms.
 */

namespace IiifServer\View\Helper;

use IiifServer\Iiif\TraitRights;
use Laminas\View\Helper\AbstractHelper;
use Omeka\Api\Representation\AbstractResourceEntityRepresentation;

/**
 * Helper to get a IIIF Collection manifest for an item set or an item with
 * external manifests.
 */
class IiifCollection2 extends AbstractHelper
{
    use TraitRights;

    /**
     * @var \Omeka\Api\Representation\AbstractResourceEntityRepresentation
     */
    protected $resource;

    /**
     * Get the IIIF Collection manifest for the specified item set or item.
     *
     * @todo Use a representation/context with a getResource(), a toString()
     * that removes empty values, a standard json() without ld and attach it to
     * event in order to modify it if needed.
     * @see IiifManifest
     *
     * @param AbstractResourceEntityRepresentation $resource
     * @return Object|null
     */
    public function __invoke(AbstractResourceEntityRepresentation $resource)
    {
        // Prepare values needed for the manifest. Empty values will be removed.
        // Some are required.
        $manifest = [
            '@context' => 'http://iiif.io/api/presentation/2/context.json',
            '@id' => '',

            '@type' => 'sc:Collection',
            'label' => '',
            'description' => '',
            'thumbnail' => '',
            'license' => '',
            'attribution' => '',
            // A logo to add at the end of the information panel.
            'logo' => '',
            'service' => '',
            // For example the web page of the item.
            'related' => '',
            // Other formats of the same data.
            'seeAlso' => '',
            'within' => '',
            'metadata' => [],
            'collections' => [],
            'manifests' => [],
        ];

        $view = $this->getView();
        $this->setting = $view->plugin('setting');

        $this->resource = $resource;
        $this->initTraitRights();

        $isItemSet = $resource->resourceName() === 'item_sets';

        if ($isItemSet) {
            $manifest = array_merge($manifest, $this->buildManifestBase($resource));
        } else {
            // Use an item with multiple external manifests as a collection.
            $manifest['@id'] = $view->url('iiifserver/collection', ['id' => $resource->id(), 'version' => '2'], ['force_canonical' => true], true);
            $forceUrlFrom = $this->setting->__invoke('iiifserver_url_force_from');
            if ($forceUrlFrom && (strpos($manifest['@id'], $forceUrlFrom) === 0)) {
                $forceUrlTo = $this->setting->__invoke('iiifserver_url_force_to');
                $manifest['@id'] = substr_replace($manifest['@id'], $forceUrlTo, 0, strlen($forceUrlFrom));
            }
            $manifest['@type'] = 'sc:Collection';
            $manifest['label'] = $resource->displayTitle();
        }

        $metadata = $this->iiifMetadata($resource);
        $manifest['metadata'] = $metadata;

        $descriptionProperty = $this->setting->__invoke('iiifserver_manifest_description_property');
        if ($descriptionProperty) {
            $description = strip_tags((string) $resource->value($descriptionProperty, ['default' => '']));
        }
        $manifest['description'] = $description;

        $license = $this->rightsResource($resource);
        if ($license) {
            $manifest['license'] = $license;
        }

        $attributionProperty = $this->setting->__invoke('iiifserver_manifest_attribution_property');
        if ($attributionProperty) {
            $attribution = strip_tags((string) $resource->value($attributionProperty, ['default' => '']));
        }
        if (empty($attribution)) {
            $attribution = $this->setting->__invoke('iiifserver_manifest_attribution_default');
        }
        $manifest['attribution'] = $attribution;

        $manifest['logo'] = $this->setting->__invoke('iiifserver_manifest_logo_default');

        // TODO Use resource thumbnail (> Omeka 1.3).
        // $manifest['thumbnail'] = $thumbnail;
        // $manifest['service'] = $service;

        /*
         // Omeka api is a service, but not referenced in https://iiif.io/api/annex/services.
         $manifest['service'] = [
             '@context' => $this->view->url('api-context', [], ['force_canonical' => true]),
             '@id' => $resource->apiUrl(),
             'format' =>'application/ld+json',
             // TODO What is the profile of Omeka json-ld?
             // 'profile' => '',
         ];
         $manifest['service'] = [
             '@context' =>'http://example.org/ns/jsonld/context.json',
             '@id' => 'http://example.org/service/example',
             'profile' => 'http://example.org/docs/example-service.html',
         ];
         */

        $manifest['related'] = [
            '@id' => $this->view->publicResourceUrl($resource, true),
            'format' => 'text/html',
        ];

        $manifest['seeAlso'] = [
            '@id' => $resource->apiUrl(),
            'format' => 'application/ld+json',
            // TODO What is the profile of Omeka json-ld?
            // 'profile' => '',
        ];

        // TODO Use within with collection tree.
        // $manifest['within'] = $within;

        // List of manifests inside the item set.
        $manifest['manifests'] = $isItemSet
            ? $this->manifestsForItemSet($resource)
            : $this->externalManifestsOfResource($resource);

        // Give possibility to customize the manifest.
        // TODO Manifest should be a true object, with many sub-objects.
        $type = 'collection';
        $params = compact('manifest', 'resource', 'type');
        $params = $this->view->plugin('trigger')->__invoke('iiifserver.manifest', $params, true);
        $manifest = $params['manifest'];

        // Remove all empty values (there is no "0" or "null" at first level).
        $manifest = array_filter($manifest);

        // Keep at least "manifests", even if no member.
        if (empty($manifest['collections']) && empty($manifest['manifests'])) {
            $manifest['manifests'] = [];
        }

        return $manifest;
    }

    /**
     * Prepare the base manifest of a resource.
     *
     * @todo Factorize with IiifManifest.
     *
     * @param AbstractResourceEntityRepresentation $resource
     * @return array
     */
    protected function buildManifestBase(AbstractResourceEntityRepresentation $resource): array
    {
        $resourceName = $resource->resourceName();
        $mapRoutes = [
            'item_sets' => 'iiifserver/collection',
            'items' => 'iiifserver/manifest',
        ];
        $mapTypes = [
            'item_sets' => 'sc:Collection',
            'items' => 'sc:Manifest',
        ];
        $manifest = [];
        $manifest['@id'] = $this->view->iiifUrl($resource, $mapRoutes[$resourceName], '2');
        $manifest['@type'] = $mapTypes[$resourceName];
        $manifest['label'] = $resource->displayTitle();
        return $manifest;
    }

    protected function manifestsForItemSet(AbstractResourceEntityRepresentation $resource): array
    {
        $manifests = [];
        $response = $this->view->api()->search('items', ['item_set_id' => $resource->id()]);
        $items = $response->getContent();
        foreach ($items as $item) {
            $manifests[] = $this->buildManifestBase($item);
        }
        return $manifests;
    }

    protected function externalManifestsOfResource(AbstractResourceEntityRepresentation $resource): array
    {
        $manifestProperty = $this->settings->get('iiifserver_manifest_external_property');
        if (empty($manifestProperty)) {
            return [];
        }

        $result = [];

        // Manage the case where the url is saved as an uri or a text and the
        // case where the property contains other values that are not url.
        foreach ($resource->value($manifestProperty, ['all' => true]) as $value) {
            if ($value->type() === 'uri') {
                $val = [
                    '@id' => $value->uri(),
                    '@type' => 'sc:Manifest',
                ];
                $label = $value->value();
                if (strlen((string) $label)) {
                    $val['label'] = $label;
                }
                $result[] = $val;
            } else {
                $urlManifest = (string) $value;
                if (filter_var($urlManifest, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
                    $result[] = [
                        '@id' => $urlManifest,
                        '@type' => 'sc:Manifest',
                    ];
                }
            }
        }

        return $result;
    }

    /**
     * Prepare the metadata of a resource.
     *
     * @todo Factorize IiifCanvas2, IiifCollection2, TraitDescriptive and IiifManifest2.
     *
     * @param AbstractResourceEntityRepresentation $resource
     * @return array
     */
    protected function iiifMetadata(AbstractResourceEntityRepresentation $resource): array
    {
        $jsonLdType = $resource->getResourceJsonLdType();
        $map = [
            'o:ItemSet' => [
                'whitelist' => 'iiifserver_manifest_properties_collection_whitelist',
                'blacklist' => 'iiifserver_manifest_properties_collection_blacklist',
            ],
            'o:Item' => [
                'whitelist' => 'iiifserver_manifest_properties_item_whitelist',
                'blacklist' => 'iiifserver_manifest_properties_item_blacklist',
            ],
            'o:Media' => [
                'whitelist' => 'iiifserver_manifest_properties_media_whitelist',
                'blacklist' => 'iiifserver_manifest_properties_media_blacklist',
            ],
        ];
        if (!isset($map[$jsonLdType])) {
            return [];
        }

        $whitelist = $this->settings->get($map[$jsonLdType]['whitelist'], []);
        if ($whitelist === ['none']) {
            return [];
        }

        $values = $whitelist
            ? array_intersect_key($resource->values(), array_flip($whitelist))
            : $resource->values();

        $blacklist = $this->settings->get($map[$jsonLdType]['blacklist'], []);
        if ($blacklist) {
            $values = array_diff_key($values, array_flip($blacklist));
        }
        if (empty($values)) {
            return [];
        }

        // TODO Remove automatically special properties, and only for values that are used (check complex conditions…).

        return $this->settings->get('iiifserver_manifest_html_descriptive')
            ? $this->valuesAsHtml($values)
            : $this->valuesAsPlainText($values);
    }

    /**
     * List values as plain text descriptive metadata.
     *
     * @param \Omeka\Api\Representation\ValueRepresentation[] $values
     * @return array
     */
    protected function valuesAsPlainText(array $values): array
    {
        $metadata = [];
        $publicResourceUrl = $this->view->plugin('publicResourceUrl');
        foreach ($values as $propertyData) {
            $valueMetadata = [];
            $valueMetadata['label'] = $propertyData['alternate_label'] ?: $propertyData['property']->label();
            $valueValues = array_filter(array_map(function ($v) use ($publicResourceUrl) {
                return strpos($v->type(), 'resource') === 0 && $vr = $v->valueResource()
                    ? $publicResourceUrl($vr, true)
                    : (string) $v;
            }, $propertyData['values']), 'strlen');
            $valueMetadata['value'] = count($valueValues) <= 1 ? reset($valueValues) : $valueValues;
            $metadata[] = $valueMetadata;
        }
        return $metadata;
    }

    /**
     * List values as descriptive metadata, with links for resources and uris.
     *
     * @param \Omeka\Api\Representation\ValueRepresentation[] $values
     * @return array
     */
    protected function valuesAsHtml(array $values): array
    {
        $metadata = [];
        $publicResourceUrl = $this->view->plugin('publicResourceUrl');
        foreach ($values as $propertyData) {
            $valueMetadata = [];
            $valueMetadata['label'] = $propertyData['alternate_label'] ?: $propertyData['property']->label();
            $valueValues = array_filter(array_map(function ($v) use ($publicResourceUrl) {
                if (strpos($v->type(), 'resource') === 0 && $vr = $v->valueResource()) {
                    return '<a class="resource-link" href="' . $publicResourceUrl($vr, true) . '">'
                        . '<span class="resource-name">' . $vr->displayTitle() . '</span>'
                        . '</a>';
                }
                return $v->asHtml();
            }, $propertyData['values']), 'strlen');
            $valueMetadata['value'] = count($valueValues) <= 1 ? reset($valueValues) : $valueValues;
            $metadata[] = $valueMetadata;
        }
        return $metadata;
    }

    /**
     * Added in order to use trait TraitRights.
     */
    protected function context(): string
    {
        return 'http://iiif.io/api/presentation/2/context.json';
    }
}
