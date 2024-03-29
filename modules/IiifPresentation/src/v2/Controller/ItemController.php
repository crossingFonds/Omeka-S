<?php
namespace IiifPresentation\v2\Controller;

use Laminas\Mvc\Controller\AbstractActionController;

class ItemController extends AbstractActionController
{
    public function viewCollectionAction()
    {
        $url = $this->url()->fromRoute('iiif-presentation-2/item/collection', [], ['force_canonical' => true], true);
        return $this->redirect()->toRoute('iiif-viewer', [], ['query' => ['url' => $url]]);
    }

    public function collectionAction()
    {
        $itemIds = explode(',', $this->params('item-ids'));
        $collection = $this->iiifPresentation2()->getItemsCollection($itemIds, $this->translate('Items Collection'));
        return $this->iiifPresentation2()->getResponse($collection);
    }

    public function viewManifestAction()
    {
        $url = $this->url()->fromRoute('iiif-presentation-2/item/manifest', [], ['force_canonical' => true], true);
        return $this->redirect()->toRoute('iiif-viewer', [], ['query' => ['url' => $url]]);
    }

    public function manifestAction()
    {
        $itemId = $this->params('item-id');
        $manifest = $this->iiifPresentation2()->getItemManifest($itemId);
        return $this->iiifPresentation2()->getResponse($manifest);
    }
}
