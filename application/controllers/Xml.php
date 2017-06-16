<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: Xml.php 2017-06-16 15:11:29 codejm $
 */

class XmlController extends \Core_BaseCtl {

    public function parseFtpAction() {
        /* {{{ */
        $find = 'api';
        $filepath = '/Users/codejm/Documents/dotfiles/FileZilla.xml';
        $xmlString = file_get_contents($filepath);
        $dom = new DOMDocument();
        $dom->loadXML($xmlString);
        $data = $this->getArray($dom->documentElement);
        $newsData = $data['Servers'][0]['Folder'][0]['Folder'][1]['Server'];

        $findData = array();
        if($newsData) {
            foreach ($newsData as $server) {
                if($server['Name'][0]['#text'] == $find) {
                    $findData = $server;
                    break;
                }
            }
        }
        print_r($findData);
        exit;

        $data = new SimpleXMLElement($xmlString);

        print_r($data); exit;
        echo '<pre>'; var_dump($data); echo '</pre>'; die();
        /* }}} */
    }


    function getArray($node) {
        $array = false;

        if ($node->hasAttributes()) {
            foreach ($node->attributes as $attr) {
                $array[$attr->nodeName] = $attr->nodeValue;
            }
        }

        if ($node->hasChildNodes()) {
            if ($node->childNodes->length == 1) {
                $array[$node->firstChild->nodeName] = $this->getArray($node->firstChild);
            } else {
                foreach ($node->childNodes as $childNode) {
                    if ($childNode->nodeType != XML_TEXT_NODE) {
                        $array[$childNode->nodeName][] = $this->getArray($childNode);
                    }
                }
            }
        } else {
            return $node->nodeValue;
        }
        return $array;
    }

   /**
     * Object to array.
     *
     *
     * @param SimpleXMLElement $obj
     *
     * @return array
     */
    protected static function normalize($obj)
    {
        $result = null;
        if (is_object($obj)) {
            $obj = (array) $obj;
        }
        if (is_array($obj)) {
            foreach ($obj as $key => $value) {
                $res = self::normalize($value);
                if (($key === '@attributes') && ($key)) {
                    $result = $res;
                } else {
                    $result[$key] = $res;
                }
            }
        } else {
            $result = $obj;
        }
        return $result;
    }

}

