<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      判断点是否在多边形内
 *      参考：http://api.map.baidu.com/library/GeoUtils/1.2/src/GeoUtils.js
 *            http://vicdory.com/determining-if-a-point-lies-on-the-interior-of-a-polygon.html
 *      $Id: Geo.php 2014-11-25 09:24:17 codejm $
 */

class Tools_Geo {

    public $pointOnVertex = true; // Check if the point sits exactly on one of the vertices?

    /**
     * 判断点是否在多边形内
     *
     */
    function isPointInPolygon($point, $polygon, $pointOnVertex = true) {

        // 如果点位于多边形的顶点或边上，也算做点在多边形内，直接返回true
        $this->pointOnVertex = $pointOnVertex;

        // 规范当前坐标数据 0:x 1:y
        if(!isset($point['x']) || !isset($point['y'])) {
            $point['x'] = $point[0];
            $point['y'] = $point[1];
        }

        // 规范多边形坐标 数据 0:x 1:y
        $vertices = array();
        foreach($polygon as $vertex) {
            if(!isset($vertex['x']) || !isset($vertex['y'])) {
                $vertex['x'] = $vertex[0];
                $vertex['y'] = $vertex[1];
            }
            $vertices[] = $vertex;
        }

        // 判断点是否在边线上(顶点)
        if($this->pointOnVertex == true && $this->isPointOnVertex($point, $vertices) == true) {
            return true;
        }

        // 基本思想是利用射线法，计算射线与多边形各边的交点，如果是偶数，则点在多边形外，否则
        // 在多边形内。还会考虑一些特殊情况，如点在多边形顶点上，点在多边形边上等特殊情况。
        $intersections = 0;
        $vertices_count = count($vertices);
        for($i=1; $i<$vertices_count; $i++) {

            $vertex1 = $vertices[$i-1];
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] && $vertex1['y'] == $point['y'] && $point['x'] > min($vertex1['x'], $vertex2['x']) && $point['x'] < max($vertex1['x'], $vertex2['x'])) {
                // Check if point is on an horizontal polygon boundary
                // return "boundary";
                return true;
            }

            if ($point['y'] > min($vertex1['y'], $vertex2['y']) && $point['y'] <= max($vertex1['y'], $vertex2['y']) && $point['x'] <= max($vertex1['x'], $vertex2['x']) && $vertex1['y'] != $vertex2['y']) {
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];
                if ($xinters == $point['x']) {
                    // Check if point is on the polygon boundary (other than horizontal)
                    // return "boundary";
                    return true;
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++;
                }
            }
        }

        if($intersections % 2 != 0) {
            // 偶数在多边形外
            return true;
        } else {
            // 奇数在多边形内
            return false;
        }
    }

    /**
     * 判断点是否在边线上
     *
     */
    function isPointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
    }

}
