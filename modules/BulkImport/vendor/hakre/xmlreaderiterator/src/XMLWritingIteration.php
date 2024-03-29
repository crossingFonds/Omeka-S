<?php
/*
 * This file is part of the XMLReaderIterator package.
 *
 * Copyright (C) 2014 hakre <http://hakre.wordpress.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author hakre <http://hakre.wordpress.com>
 * @license AGPL-3.0-or-later <https://spdx.org/licenses/AGPL-3.0-or-later>
 */

/**
 * Class XMLWritingIteration
 *
 * @since 0.1.2
 *
 * @method XMLReader current()
 * @mixin XMLReaderIteration
 */
class XMLWritingIteration extends IteratorIterator
{
    /**
     * @var XMLWriter
     */
    private $writer;

    /**
     * @var XMLReader
     */
    private $reader;

    public function __construct(XMLWriter $writer, XMLReader $reader) {
        $this->writer = $writer;
        $this->reader = $reader;

        parent::__construct(new XMLReaderIteration($reader));
    }

    public function write() {
        $reader = $this->reader;
        $writer = $this->writer;

        switch ($reader->nodeType) {
            case XMLReader::ELEMENT:
                $writer->startElement($reader->name);

                if ($reader->moveToFirstAttribute()) {
                    do {
                        $writer->writeAttribute($reader->name, $reader->value);
                    } while ($reader->moveToNextAttribute());
                    $reader->moveToElement();
                }

                if ($reader->isEmptyElement) {
                    $writer->endElement();
                }
                break;

            case XMLReader::END_ELEMENT:
                $writer->endElement();
                break;

            case XMLReader::CDATA:
                $writer->writeCdata($reader->value);
                break;

            case XMLReader::COMMENT:
                $writer->writeComment($reader->value);
                break;

            case XMLReader::SIGNIFICANT_WHITESPACE:
            case XMLReader::TEXT:
            case XMLReader::WHITESPACE:
                $writer->text($reader->value);
                break;

            case XMLReader::PI:
                $writer->writePi($reader->name, $reader->value);
                break;

            default:
                trigger_error(sprintf(
                    '%s::write(): Node-type not implemented: %s',
                    __CLASS__,
                    XMLReaderNode::dump($reader, true)
                ), E_USER_WARNING);
        }
    }
}
