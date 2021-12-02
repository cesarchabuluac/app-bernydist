<?php
class Mcatalogo extends CI_Model
{
    private static $nullKeyword = array(
        //Pronombres
        ' algo ',
        ' alguna  ',
        ' alguno ',
        ' aquel ',
        ' aquella ',
        ' aquello ',
        ' bastante ',
        ' como ',
        ' cual ',
        ' cuanta ',
        ' cuanto ',
        ' cuya ',
        ' cuyo ',
        ' demasiada ',
        ' demasiado ',
        ' donde ',
        ' el ',
        ' esa ',
        ' ese ',
        ' eso ',
        ' esta ',
        ' este ',
        ' esto ',
        ' lo ',
        ' me ',
        ' mi ',
        ' mia ',
        ' mio ',
        ' mucha ',
        ' mucho ',
        ' nada ',
        ' ninguna ',
        ' ninguno ',
        ' nuestra ',
        ' nuestro ',
        ' poca ',
        ' poco ',
        ' que ',
        ' quien ',
        ' se ',
        ' su ',
        ' suya ',
        ' suyo ',
        ' tanta ',
        ' tanto ',
        ' te ',
        ' tu ',
        ' tuya ',
        ' tuyo ',
        ' usted ',
        ' vuestra ',
        ' vuestro ',
        ' yo ',
        //Preposiciones
        ' a  ',
        ' ante ',
        ' bajo ',
        ' cabe  ',
        ' con  ',
        ' contra ',
        ' de ',
        ' desde ',
        ' durante ',
        ' en ',
        ' entre ',
        ' hacia ',
        ' hasta ',
        ' mediante ',
        ' para ',
        ' por ',
        ' según ',
        ' sin  ',
        ' so ',
        ' sobre ',
        ' tras ',
        ' versus ',
        ' via ',
        " ",
        " ",
        ""
    );

    private static $suffixes = array(
        "es",
        "s",
        "en",
        "n"
    );
    function removeDiacritics($stringToClean)
    {

        $stringToClean = urldecode($stringToClean);

        $stringToClean = str_replace(
            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
            array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
            $stringToClean
        );

        $stringToClean = str_replace(
            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
            array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
            $stringToClean
        );

        $stringToClean = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
            $stringToClean
        );

        $stringToClean = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
            $stringToClean
        );

        $stringToClean = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
            $stringToClean
        );

        return $stringToClean;
    }

    function paginacion($limit, $offset, $busqueda, $divisions, $categories, $brands, $isPaging = false)
    {

        //Eliminamos las palabras no permitidas
        for ($i = 0; $i < count(self::$nullKeyword); $i++) {
            $busqueda = str_replace(self::$nullKeyword[$i], " ", $busqueda);
        }

        $aKeyword = explode(" ", $busqueda);

        $this->db->select("count(*) as products_like,gd.division_id");
        $this->db->from("products as p");
        $this->db->join("groups_divisions as gd", " gd.category_id = p.category_id");
        $this->db->join("categories as c", "c.id = gd.category_id");

        if (!empty($busqueda)) {

            $this->db->like("p.details", $aKeyword[0], "both");
            $this->db->or_like("p.product_code", $aKeyword[0], "both");
            $this->db->or_like("c.name", $aKeyword[0], "both");

            for ($i = 1; $i < count($aKeyword); $i++) {
                if (!empty($aKeyword[$i])) {
                    $word = str_replace(self::$nullKeyword[$i], " ", $aKeyword[$i]);
                    $this->db->or_like("p.details", $word, "both");
                    $this->db->or_like("p.product_code", $word, "both");
                    $this->db->or_like("p.ofb", $word, "both");
                    $this->db->or_like("c.name", $word, "both");
                }
            }
        }

        if (!empty($categories)) {
            $this->db->where_in("gd.category_id", $categories);
        }
        if (!empty($brands)) {
            $this->db->where_in("p.brand_id", $brands);
        }
        $this->db->group_by("gd.division_id");
        $this->db->get();
        $subquery = $this->db->last_query();
        $data = array("filas" => 0, "resultados" => []);
        $select = "d.id, d.name"; #select verdadero
        $this->db->select("1 as columna", FALSE);
        $this->db->join("groups_divisions as gd", "gd.division_id = d.id");
        $this->db->join("groups as g", "gd.group_id = g.id");
        $this->db->join("categories as c", "c.id = gd.category_id");

        if (!empty($busqueda) || !empty($categories) || !empty($brands)) {
            $this->db->join(
                "(" . $subquery . ") as p",
                "p.division_id = d.id"
            );
            $this->db->where("p.products_like > 0", null, null);
        }
        if (!empty($divisions)) {
            $this->db->where_in("d.id", $divisions);
        }
        $this->db->order_by("c.created_at asc");

        $this->db->order_by("g.orden_catalogo asc,d.clave asc");
        $this->db->group_by(["g.id", "d.id"]);
        $data["filas"] = $this->db->get('divisions as d')->num_rows();
        #los filtros son iguales siempre, solo cambia el select, para sacar el numero de columnas obtenemos solo un campo columna con valor 1, posteriormente se reemplazará con el select verdadero a la query hecha anteriormente
        $query = str_replace("1 as columna", $select, $this->db->last_query());
        #ya con el select verdadero adjunto a la query se le concatena un limit y un offset
        //$resultados = $this->db->query($query." limit ".$limit." offset ".$offset);
        $resultados = ($isPaging) ? $this->db->query($query . " limit " . $limit . " offset " . $offset) : $this->db->query($query);
        // print_r($query); exit();
        if ($data["filas"] > 0) {
            foreach ($resultados->result() as $fila) {
                $data["resultados"][] = $fila;
            }
        }

        // echo $this->db->last_query();
        // exit();
        return $data;
    }

    function existe($division)
    {
        $this->db->select("c.id");
        $this->db->join("categories as c", "c.id = ac.category_id");
        $this->db->where("ac.division_id", $division);
        $this->db->order_by("c.orden_catalogo", "asc");
        $this->db->group_by("ac.category_id");
        $query = $this->db->get("all_categories as ac");
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if (!$length) {
            return true;
        }
        return substr($haystack, -$length) === $needle;
    }

    function cleanSearchInput($searchInput)
    {
        //Eliminamos las palabras no permitidas
        $busqueda = str_replace("_", " ", $searchInput);
        for ($i = 0; $i < count(self::$nullKeyword); $i++) {
            $busqueda = str_replace(self::$nullKeyword[$i], " ", $busqueda);
        }
        $busqueda = self::removeDiacritics($busqueda);
        $aKeyword = explode(" ", $busqueda);

        for ($i = 0; $i < count($aKeyword); $i++) {
            $stringTmp = $aKeyword[$i];
            for ($j = 0; $j < count(self::$suffixes); $j++) {
                if (self::endsWith($stringTmp, self::$suffixes[$j])) {
                    $stringTmp = substr($stringTmp, 0, -1 * strlen(self::$suffixes[$j]));
                    $aKeyword[$i] = $stringTmp;
                }
            }
        }
        return $aKeyword;
    }

    function get_categories_by_division($limit, $offset, $busqueda, $division, $categories, $brands, $groups, $lines, $userId, $newest, $orden, $relevant, $isPaging = false)
    {
        $user = (isset($this->data['user']) && !empty($this->data['user'])) ? $this->data['user'] : null;

        //Eliminamos las palabras no permitidas
        $busqueda = str_replace("_", " ", $busqueda);
        for ($i = 0; $i < count(self::$nullKeyword); $i++) {
            $busqueda = str_replace(self::$nullKeyword[$i], " ", $busqueda);
        }
        $busqueda = self::removeDiacritics($busqueda);
        $aKeyword = explode(" ", $busqueda);

        for ($i = 0; $i < count($aKeyword); $i++) {
            $stringTmp = $aKeyword[$i];
            for ($j = 0; $j < count(self::$suffixes); $j++) {
                if (self::endsWith($stringTmp, self::$suffixes[$j])) {
                    $stringTmp = substr($stringTmp, 0, -1 * strlen(self::$suffixes[$j]));
                    $aKeyword[$i] = $stringTmp;
                }
            }
        }

        $this->db->select("count(*) as number_products, sum(ga.views) as views, p.category_id");
        $this->db->from("products as p");
        $this->db->join("groups_divisions as gd", " gd.category_id = p.category_id");
        $this->db->join("categories as c", "c.id = gd.category_id");
        $this->db->join("G_Analytics as ga", "p.id = ga.product_id", "left");
        $isJoinGiros = false;

        if (!empty($groups) || !empty($busqueda)) {
            if (!empty($lines)) {
                $isJoinGiros = true;
                $this->db->join("ARTICULOS_GIROS as gr", " gr.ARTICULO_ID = p.id");                
            } else {
                $isJoinGiros = true;
                $this->db->join("ARTICULOS_GIROS as gr", " gr.ARTICULO_ID = p.id", "left");
            }
        }

       

        if (!empty($busqueda)) {

            $this->db->join("INFORMACION_ARTS as i", "i.ARTICULO_ID = p.id", "left");
            $this->db->join("brands bnd", "p.brand_id = bnd.id"); //marcas
            $this->db->join("BR_GIROS as bgr", " gr.GIRO_ID = bgr.giro_id", "left"); //giros
            $this->db->join("groups as gp", " gp.id = p.group_id", "left"); //grupos o departamentos
            $this->db->join("divisions as dvs", " dvs.id = gd.division_id"); //divisiones           

            $this->db->where("( 
                c.name LIKE '%{$aKeyword[0]}%' 
                OR p.details LIKE '%{$aKeyword[0]}%' 
                OR p.product_code LIKE '%{$aKeyword[0]}%' 
                OR p.codigo LIKE '%{$aKeyword[0]}%' 
                OR p.ofb LIKE '%{$aKeyword[0]}%' 
                OR i.INFORMACION LIKE '%{$aKeyword[0]}%' 
                OR bnd.name LIKE '%{$aKeyword[0]}%' 
                OR bgr.nombre LIKE '%{$aKeyword[0]}%' 
                OR gp.nombre_etiqueta LIKE '%{$aKeyword[0]}%' 
                OR dvs.name LIKE '%{$aKeyword[0]}%' 
                )");

            /*
            $this->db->like("c.name", $aKeyword[0], "both");  
            $this->db->or_like("p.details", $aKeyword[0], "both");
            $this->db->or_like("p.product_code", $aKeyword[0], "both");
            $this->db->or_like("p.codigo", $aKeyword[0], "both");
            $this->db->or_like("p.ofb", $aKeyword[0], "both");
            $this->db->or_like("i.INFORMACION", $aKeyword[0], "both");
            $this->db->or_like("bnd.name", $aKeyword[0], "both");//nombre de marca
            $this->db->or_like("bgr.nombre", $aKeyword[0], "both");//nombre de giro
            $this->db->or_like("gp.nombre_etiqueta", $aKeyword[0], "both");//nombre de grupo o departamento
            $this->db->or_like("dvs.name", $aKeyword[0], "both");//nombre de division
            */

            $selectWeights = "";
            for ($i = 1; $i < count($aKeyword); $i++) {
                if (!empty($aKeyword[$i])) {
                    $word = str_replace(self::$nullKeyword[$i], " ", $aKeyword[$i]);
                    /*
                    $this->db->or_like("p.details", $word, "both");
                    $this->db->or_like("p.product_code", $word, "both");
                    $this->db->or_like("p.codigo", $word, "both");
                    $this->db->or_like("c.name", $word, "both");
                    $this->db->or_like("p.ofb", $word, "both");
                    $this->db->or_like("i.INFORMACION", $word, "both");
                    $this->db->or_like("bnd.name", $word, "both");//nombre de marca
                    $this->db->or_like("bgr.nombre", $word, "both");//nombre de giro
                    $this->db->or_like("gp.nombre_etiqueta", $word, "both");//nombre de grupo o departamento
                    $this->db->or_like("dvs.name", $word, "both");//nombre de division
                    */
                    $this->db->or_where("( 
                        c.name LIKE '%{$word}%' 
                        OR p.details LIKE '%{$word}%' 
                        OR p.product_code LIKE '%{$word}%' 
                        OR p.codigo LIKE '%{$word}%' 
                        OR p.ofb LIKE '%{$word}%' 
                        OR i.INFORMACION LIKE '%{$word}%' 
                        OR bnd.name LIKE '%{$word}%' 
                        OR bgr.nombre LIKE '%{$word}%' 
                        OR gp.nombre_etiqueta LIKE '%{$word}%' 
                        OR dvs.name LIKE '%{$word}%' 
                        )");

                    $selectWeights = $selectWeights .
                        "+ IF (c.name LIKE '%" . $word . "%',  2, 0)
                    + IF (p.details LIKE '%" . $word . "%', 3,  0)
                    + IF (i.INFORMACION LIKE '%" . $word . "%', 1,  0)
                    + IF (p.product_code LIKE '%" . $word . "%', 4,  0)
                    + IF (p.codigo LIKE '%" . $word . "%', 4,  0)
                    + IF (bnd.name LIKE '%" . $word . "%', 1,  0)
                    + IF (bgr.nombre LIKE '%" . $word . "%', 1,  0)
                    + IF (gp.nombre_etiqueta LIKE '%" . $word . "%', 1,  0)
                    + IF (dvs.name LIKE '%" . $word . "%', 1,  0)
                    + IF (p.ofb LIKE '%" . $word . "%', 1,  0) ";
                }
            }



            $this->db->select(" 
            IF (c.name LIKE '" . $aKeyword[0] . "%',  1, 0)
            + IF (c.name LIKE '%" . $aKeyword[0] . "%',  2, 0)
            + IF (p.details LIKE '%" . $aKeyword[0] . "%', 3,  0)
            + IF (p.product_code LIKE '%" . $aKeyword[0] . "%', 4,  0)
            + IF (p.codigo LIKE '%" . $aKeyword[0] . "%', 4,  0)
            + IF (p.ofb LIKE '%" . $aKeyword[0] . "%', 1,  0)
            + IF (i.INFORMACION LIKE '%" . $aKeyword[0] . "%', 1,  0)
            + IF (bnd.name LIKE '%" . $aKeyword[0] . "%', 1,  0)
            + IF (bgr.nombre LIKE '%" . $aKeyword[0] . "%', 1,  0)
            + IF (gp.nombre_etiqueta LIKE '%" . $aKeyword[0] . "%', 1,  0)
            + IF (dvs.name LIKE '%" . $aKeyword[0] . "%', 1,  0)
            " . $selectWeights . "
            AS 'weight'", false);
        }

        if (!empty($division)) {
            $this->db->where_in("gd.division_id", $division);
        }
        if (!empty($categories)) {
            $this->db->where_in("gd.category_id", $categories);
        }
        if (!empty($brands)) {
            $this->db->where_in("p.brand_id", $brands);
        }
        if (!empty($groups)) { //Departamentos
            $this->db->where_in("p.group_id", $groups);
        }
        if (!empty($lines)) {
            if (empty($groups) || empty($busqueda)) {
                if (!$isJoinGiros) {
                    $isJoinGiros = true;
                    $this->db->join("ARTICULOS_GIROS as gr", " gr.ARTICULO_ID = p.id");
                }
            }
            if ($isJoinGiros) {
                $this->db->where_in("gr.GIRO_ID", $lines);
            }
        }
        if (!empty($userId)) {
            $this->db->select("pw.created_at as order_creation");
            $this->db->join("pedidos_web_detalle as pwd", "pwd.ARTICULO_ID = p.id");
            $this->db->join("pedidos_web2 as pw", "pw.pedidos_web_id = pwd.pedido_web_id");
            $this->db->where_in('pw.ESTATUS', 2);
            $this->db->where_in("pw.CLIENTE_ID", $userId);
        }

        if (!empty($user)) {
            if (!empty($user->LOCALIDAD_ID)) {
                $this->db->select('claf.PCTJ_FLETE');
                $this->db->join("_CONFIG_LOC_ART_FL as claf", " p.tipo_articulo_flete = claf.TIPO_ARTICULO");
                $this->db->join("_LOCALIDADES as l", "claf.TIPO_LOCALIDAD = l.TIPO_LOCALIDAD OR l.TIPO_LOCALIDAD is null");
                $this->db->where('l.LOCALIDAD_ID', $user->LOCALIDAD_ID);
            }
        }



        $this->db->group_by("gd.division_id,gd.category_id");

        if (!empty($userId)) {
            $this->db->order_by("pw.created_at", "DESC");
        }

        $this->db->get();
        $subquery = $this->db->last_query();

        $this->db->select("ac.*, p2.number_products, d.*, gp.orden_catalogo, p2.views");
        $this->db->join("categories as c", "c.id = ac.category_id");

        $this->db->join(
            "(" . $subquery . ") as p2",
            "p2.category_id = c.id"
        );

        if (!empty($busqueda)) {
            $this->db->select("weight");
            $this->db->order_by("weight", "desc");
        } else {

            if (!empty($userId)) {
                $this->db->select("ac.*, p2.number_products, p2.order_creation, d.*, gp.orden_catalogo, p2.views");
                $this->db->order_by("p2.order_creation", "desc");
            } else if (!empty($relevant)) {
                $this->db->order_by("c.orden_relevancia", "desc");
            } else if (!empty($orden)) {
                $this->db->order_by("gp.orden_catalogo", "asc");
                $this->db->order_by("d.name", "asc");
                $this->db->order_by("c.orden_catalogo", "asc");
                $this->db->order_by("c.name", "asc");
            } else if (empty($division) && empty($categories) && empty($brands) && empty($groups) && empty($lines)) {
                $this->db->order_by("c.updated_at", "desc");
            } else {
                // $this->db->order_by("gp.orden_catalogo", "asc");
                // $this->db->order_by("d.clave", "asc"); 
                $this->db->order_by("c.orden_catalogo", "asc");
            }
        }

        if (!empty($user)) {
            if (!empty($user->LOCALIDAD_ID)) {
                $this->db->select("p2.PCTJ_FLETE");
            }
        }

        $this->db->group_by("ac.category_id");
        $this->db->join("groups_divisions as gd", " gd.category_id = ac.category_id");
        $this->db->join("groups as gp", " gd.group_id = gp.id");
        $this->db->join("divisions as d", " gd.division_id = d.id");

        $this->db->limit($limit, $offset);
        $query = $this->db->get("all_categories as ac");
        // print_r($this->db->last_query()); exit();

        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function get_categories_by_division_pagination($limit, $offset, $busqueda, $division, $categories, $brands, $groups, $lines, $userId, $newest, $orden, $relevant, $isPaging = false)
    {
        $user = (isset($this->data['user']) && !empty($this->data['user'])) ? $this->data['user'] : null;

        //Eliminamos las palabras no permitidas
        $busqueda = str_replace("_", " ", $busqueda);
        for ($i = 0; $i < count(self::$nullKeyword); $i++) {
            $busqueda = str_replace(self::$nullKeyword[$i], " ", $busqueda);
        }
        $busqueda = self::removeDiacritics($busqueda);
        $aKeyword = explode(" ", $busqueda);

        for ($i = 0; $i < count($aKeyword); $i++) {
            $stringTmp = $aKeyword[$i];
            for ($j = 0; $j < count(self::$suffixes); $j++) {
                if (self::endsWith($stringTmp, self::$suffixes[$j])) {
                    $stringTmp = substr($stringTmp, 0, -1 * strlen(self::$suffixes[$j]));
                    $aKeyword[$i] = $stringTmp;
                }
            }
        }

        $this->db->select("count(*) as number_products, p.category_id");
        $this->db->from("products as p");
        $this->db->join("groups_divisions as gd", " gd.category_id = p.category_id");
        $this->db->join("categories as c", "c.id = gd.category_id");

        // if (!empty($user)) {
        //     $this->db->select('claf.PCTJ_FLETE');
        //     $this->db->join("_CONFIG_LOC_ART_FL as claf", " p.tipo_articulo_flete = claf .TIPO_ARTICULO");
        //     $this->db->join("_localidades as l", " claf.TIPO_LOCALIDAD = l.TIPO_LOCALIDAD ");
        //     $this->db->where('l.localidad_id', $user->LOCALIDAD_ID);
        // }

        $isJoinGiros = false;
        if (!empty($groups) || !empty($busqueda)) {
            if (!empty($lines)) {
                $isJoinGiros = true;
                $this->db->join("ARTICULOS_GIROS as gr", " gr.ARTICULO_ID = p.id");
            } else {
                $isJoinGiros = true;
                $this->db->join("ARTICULOS_GIROS as gr", " gr.ARTICULO_ID = p.id", "left");
            }
        }
        if (!empty($busqueda)) {
            $this->db->join("INFORMACION_ARTS as i", "i.ARTICULO_ID = p.id", "left");
            $this->db->join("BR_GIROS as bgr", " gr.GIRO_ID = bgr.giro_id", "left");
            $this->db->join("brands bnd", "p.brand_id = bnd.id");
            $this->db->join("groups as gp", " gp.id = p.group_id", "left");
            $this->db->join("divisions as dvs", " dvs.id = gd.division_id");
            /*
            $this->db->like("c.name", $aKeyword[0], "both");  
            $this->db->or_like("p.details", $aKeyword[0], "both");
            $this->db->or_like("p.product_code", $aKeyword[0], "both");
            $this->db->or_like("p.ofb", $aKeyword[0], "both");
            $this->db->or_like("i.INFORMACION", $aKeyword[0], "both");
            $this->db->or_like("bnd.name", $aKeyword[0], "both");//nombre de marca
            $this->db->or_like("bgr.nombre", $aKeyword[0], "both");//nombre de giro
            $this->db->or_like("gp.nombre_etiqueta", $aKeyword[0], "both");//nombre de grupo o departamento
            $this->db->or_like("dvs.name", $aKeyword[0], "both");//nombre de division
            */
            $this->db->where("( 
                c.name LIKE '%{$aKeyword[0]}%' 
                OR p.details LIKE '%{$aKeyword[0]}%' 
                OR p.product_code LIKE '%{$aKeyword[0]}%' 
                OR p.codigo LIKE '%{$aKeyword[0]}%' 
                OR p.ofb LIKE '%{$aKeyword[0]}%' 
                OR i.INFORMACION LIKE '%{$aKeyword[0]}%' 
                OR bnd.name LIKE '%{$aKeyword[0]}%' 
                OR bgr.nombre LIKE '%{$aKeyword[0]}%' 
                OR gp.nombre_etiqueta LIKE '%{$aKeyword[0]}%' 
                OR dvs.name LIKE '%{$aKeyword[0]}%' 
                )");

            $selectWeights = "";
            for ($i = 1; $i < count($aKeyword); $i++) {
                if (!empty($aKeyword[$i])) {
                    $word = str_replace(self::$nullKeyword[$i], " ", $aKeyword[$i]);
                    /*
                    $this->db->or_like("p.details", $word, "both");
                    $this->db->or_like("p.product_code", $word, "both");
                    $this->db->or_like("c.name", $word, "both");
                    $this->db->or_like("p.ofb", $word, "both");
                    $this->db->or_like("i.INFORMACION", $word, "both");
                    $this->db->or_like("bnd.name", $word, "both");//nombre de marca
                    $this->db->or_like("bgr.nombre", $word, "both");//nombre de giro
                    $this->db->or_like("gp.nombre_etiqueta", $word, "both");//nombre de grupo o departamento
                    $this->db->or_like("dvs.name", $word, "both");//nombre de division
                    */
                    $this->db->or_where("( 
                        c.name LIKE '%{$word}%' 
                        OR p.details LIKE '%{$word}%' 
                        OR p.product_code LIKE '%{$word}%' 
                        OR p.codigo LIKE '%{$word}%' 
                        OR p.ofb LIKE '%{$word}%' 
                        OR i.INFORMACION LIKE '%{$word}%' 
                        OR bnd.name LIKE '%{$word}%' 
                        OR bgr.nombre LIKE '%{$word}%' 
                        OR gp.nombre_etiqueta LIKE '%{$word}%' 
                        OR dvs.name LIKE '%{$word}%' 
                        )");

                    $selectWeights = $selectWeights .
                        "+ IF (c.name LIKE '%" . $word . "%',  2, 0)
                    + IF (p.details LIKE '%" . $word . "%', 3,  0)
                    + IF (i.INFORMACION LIKE '%" . $word . "%', 1,  0)
                    + IF (p.product_code LIKE '%" . $word . "%', 4,  0)
                    + IF (p.codigo LIKE '%" . $word . "%', 4,  0)
                    + IF (bnd.name LIKE '%" . $word . "%', 1,  0)
                    + IF (bgr.nombre LIKE '%" . $word . "%', 1,  0)
                    + IF (gp.nombre_etiqueta LIKE '%" . $word . "%', 1,  0)
                    + IF (dvs.name LIKE '%" . $word . "%', 1,  0)
                    + IF (p.ofb LIKE '%" . $word . "%', 1,  0) ";
                }
            }
            $this->db->select(" 
            IF (c.name LIKE '" . $aKeyword[0] . "%',  1, 0)
            + IF (c.name LIKE '%" . $aKeyword[0] . "%',  2, 0)
            + IF (p.details LIKE '%" . $aKeyword[0] . "%', 3,  0)
            + IF (p.product_code LIKE '%" . $aKeyword[0] . "%', 4,  0)
            + IF (p.codigo LIKE '%" . $aKeyword[0] . "%', 4,  0)
            + IF (p.ofb LIKE '%" . $aKeyword[0] . "%', 1,  0)
            + IF (i.INFORMACION LIKE '%" . $aKeyword[0] . "%', 1,  0)
            + IF (bnd.name LIKE '%" . $aKeyword[0] . "%', 1,  0)
            + IF (bgr.nombre LIKE '%" . $aKeyword[0] . "%', 1,  0)
            + IF (gp.nombre_etiqueta LIKE '%" . $aKeyword[0] . "%', 1,  0)
            + IF (dvs.name LIKE '%" . $aKeyword[0] . "%', 1,  0)
            " . $selectWeights . "
            AS 'weight'", false);
        }
        if (!empty($division)) {
            $this->db->where_in("gd.division_id", $division);
        }
        if (!empty($categories)) {
            $this->db->where_in("gd.category_id", $categories);
        }
        if (!empty($brands)) {
            $this->db->where_in("p.brand_id", $brands);
        }
        if (!empty($groups)) {
            $this->db->where_in("p.group_id", $groups);
        }

        if (!empty($lines)) {
            if (empty($groups) || empty($busqueda)) {
                if (!$isJoinGiros) {
                    $isJoinGiros = true;
                    $this->db->join("ARTICULOS_GIROS as gr", " gr.ARTICULO_ID = p.id");
                }
                
            }

            if ($isJoinGiros) {
                $this->db->where_in("gr.GIRO_ID", $lines);
            }
            
        }
        if (!empty($userId)) {
            $this->db->join("pedidos_web_detalle as pwd", "pwd.ARTICULO_ID = p.id");
            $this->db->join("pedidos_web2 as pw", "pw.pedidos_web_id = pwd.pedido_web_id");
            $this->db->where_in("pw.CLIENTE_ID", $userId);
        }

        // if (!empty($user)) {
        //     $this->db->select("p2.PCTJ_FLETE");
        // }

        //$this->db->limit($limit,$offset);
        $this->db->group_by("gd.division_id,gd.category_id");
        $products = $this->db->get();

        $data = array("filas" => 0, "resultados" => [], "products_count" => 0);
        //$data["products_count"] = $products->num_rows();

        $subquery = $this->db->last_query();

        $productCountQuery = $this->db->last_query();

        $this->db->select("ac.*,d.name, gp.orden_catalogo");

        $this->db->join("categories as c", "c.id = ac.category_id");

        $this->db->join(
            "(" . $subquery . ") as p2",
            "p2.category_id = c.id"
        );

        if (!empty($busqueda)) {
            $this->db->select("weight");
            $this->db->order_by("weight", "desc");
        } else {
            if (!empty($userId)) {
                $this->db->order_by("c.created_at", "desc");
            } else if (!empty($relevant)) {
                $this->db->order_by("c.orden_relevancia", "desc");
            } else if (!empty($orden)) {
                $this->db->order_by("gp.orden_catalogo", "asc");
                $this->db->order_by("d.name", "asc");
                $this->db->order_by("c.orden_catalogo", "asc");
                $this->db->order_by("c.name", "asc");
            } else if (empty($division) && empty($categories) && empty($brands) && empty($groups) && empty($lines)) {
                $this->db->order_by("c.updated_at", "desc");
            } else {
                //$this->db->order_by("gp.orden_catalogo", "desc");
                //$this->db->order_by("d.name", "desc");
                $this->db->order_by("c.orden_catalogo", "desc");
            }
        }




        //$this->db->order_by("c.updated_at", "desc");
        $this->db->group_by("ac.category_id");
        //$this->db->join("G_Analytics as ga", "ac.category_id = ga.category_id","left");
        $this->db->join("groups_divisions as gd", " gd.category_id = ac.category_id");
        $this->db->join("groups as gp", " gd.group_id = gp.id");
        $this->db->join("divisions as d", " gd.division_id = d.id");
        $query = $this->db->get("all_categories as ac");

        //return ($query->num_rows() > 0) ? $query->result() : [];
        $data["filas"] = $query->num_rows();
        //$data["filas"] = $this->db->get('divisions as d')->num_rows();
        #los filtros son iguales siempre, solo cambia el select, para sacar el numero de columnas obtenemos solo un campo columna con valor 1, posteriormente se reemplazará con el select verdadero a la query hecha anteriormente
        $select = "c.id, c.name"; #select verdadero
        $query = str_replace("1 as columna", $select, $this->db->last_query());
        #ya con el select verdadero adjunto a la query se le concatena un limit y un offset
        //$resultados = $this->db->query($query." limit ".$limit." offset ".$offset);

        $resultados = $this->db->query($query . " limit " . $limit . " offset " . $offset);

        $productCountQuery = str_replace("GROUP BY `gd`.`division_id`, `gd`.`category_id`", "GROUP BY `p`.`id`", $productCountQuery);

        $productsCount = $this->db->query($productCountQuery);
        $data["products_count"] = $productsCount->num_rows();

        if ($data["filas"] > 0) {
            foreach ($resultados->result() as $fila) {
                $data["resultados"][] = $fila;
            }
        }

        // echo $this->db->last_query();
        // exit();
        return $data;
    }

    function get_category_by_division($division, $order)
    {
        $this->db->select("c.id");
        $this->db->join("categories as c", "c.id = ac.category_id");
        $this->db->where("ac.division_id", $division);
        $this->db->order_by("c.orden_catalogo", $order); //asc or desc
        $this->db->limit(1);
        $this->db->group_by("ac.category_id");
        $query = $this->db->get("all_categories as ac");
        return ($query->num_rows() > 0) ? $query->row() : [];
    }
    function get_categoria($id_categoria)
    {
        $this->db->select("categories.*, gd.division_id");
        $this->db->where("categories.id", $id_categoria);
        $this->db->join("groups_divisions as gd", " gd.category_id = categories.id");
        $query = $this->db->get("categories");
        return ($query->num_rows() > 0) ? $query->row() : [];
    }

    function get_categoria_by_product_id($product_id)
    {
        $this->db->select("categories.*, gd.division_id");
        // $this->db->where("categories.id", $id_categoria);
        $this->db->join('products as p', "categories.id = p.category_id");
        $this->db->where('p.id', $product_id);
        $this->db->join("groups_divisions as gd", " gd.category_id = categories.id");
        $query = $this->db->get("categories");
        return ($query->num_rows() > 0) ? $query->row() : [];
    }

    function getProductsByCategory($id_categoria, $product_code = NULL)
    {

        $user = (isset($this->data['user']) && !empty($this->data['user'])) ? $this->data['user'] : null;

        $this->db->select("products.*, brands.clave as 'brand_clave', brands.name as 'brand_name', ima.IMAGEN_ARTICULO_ID as 'image', ga.views, ga.adds, ga.purchases");
        $this->db->from("products, brands");
        $this->db->join("IMAGENES_ARTICULOS as ima", "products.id = ima.ARTICULO_ID", "left");        
        $this->db->join("G_Analytics as ga", "products.id = ga.product_id", "left");

        if (!empty($user)) {
            if (!empty($user->LOCALIDAD_ID)) {
                $this->db->select('claf.PCTJ_FLETE');
                $this->db->join("_CONFIG_LOC_ART_FL as claf", " products.tipo_articulo_flete = claf.TIPO_ARTICULO");
                $this->db->join("_LOCALIDADES as l", "claf.TIPO_LOCALIDAD = l.TIPO_LOCALIDAD OR l.TIPO_LOCALIDAD is null");
                $this->db->where('l.LOCALIDAD_ID', $user->LOCALIDAD_ID);
            }
        }        
        $this->db->where("products.brand_id = brands.id", null, null);
        $this->db->where("products.category_id", $id_categoria);
        //$this->db->where("G_Analytics.category_id", $id_categoria);
        if (!empty($product_code)) {
            $this->db->where('products.product_code', $product_code);
        }
        // $this->db->where('ria.ROL_IMAGEN_ART_ID', 104132459);
        $this->db->group_by("products.id");
        $this->db->order_by("products.orden_catalogo", "ASC");

        $query = $this->db->get();
        // echo "<pre>";
        // print_r($query);
        // echo $this->db->last_query();
        // exit();
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function get_products($id_categoria, $product_code = NULL, $joinRoles = true)
    {

        $user = (isset($this->data['user']) && !empty($this->data['user'])) ? $this->data['user'] : null;

        $this->db->select("products.*, brands.clave as 'brand_clave', brands.name as 'brand_name', ima.IMAGEN_ARTICULO_ID as 'image', ga.views, ga.adds, ga.purchases");
        $this->db->from("products, brands");
        $this->db->join("IMAGENES_ARTICULOS as ima", "products.id = ima.ARTICULO_ID", "left");        
        $this->db->join("G_Analytics as ga", "products.id = ga.product_id", "left");

        if (!empty($user)) {
            if (!empty($user->LOCALIDAD_ID)) {
                $this->db->select('claf.PCTJ_FLETE');
                $this->db->join("_CONFIG_LOC_ART_FL as claf", " products.tipo_articulo_flete = claf.TIPO_ARTICULO");
                $this->db->join("_LOCALIDADES as l", "claf.TIPO_LOCALIDAD = l.TIPO_LOCALIDAD OR l.TIPO_LOCALIDAD is null");
                $this->db->where('l.LOCALIDAD_ID', $user->LOCALIDAD_ID);
            }
        }
        if ($joinRoles) {
            $this->db->join("ROLES_IMAGENES_ARTICULOS as ria", "ima.ROL_IMAGEN_ART_ID = ria.ROL_IMAGEN_ART_ID AND ria.ROL_IMAGEN_ART_ID = 104132459");
        }
        
        $this->db->where("products.brand_id = brands.id", null, null);
        $this->db->where("products.category_id", $id_categoria);
        //$this->db->where("G_Analytics.category_id", $id_categoria);
        if (!empty($product_code)) {
            $this->db->where('products.product_code', $product_code);
        }
        // $this->db->where('ria.ROL_IMAGEN_ART_ID', 104132459);
        $this->db->group_by("products.id");
        $this->db->order_by("products.orden_catalogo", "ASC");

        $query = $this->db->get();
        // echo "<pre>";
        // print_r($query);
        // echo $this->db->last_query();
        // exit();
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function get_products_by_equivalent($agrupador = NULL, $exclude=null,  $joinRoles = false)
    {

        $user = (isset($this->data['user']) && !empty($this->data['user'])) ? $this->data['user'] : null;

        $this->db->select("products.*, brands.clave as 'brand_clave', brands.name as 'brand_name', ima.IMAGEN_ARTICULO_ID as 'image', ga.views, ga.adds, ga.purchases");
        $this->db->from("products, brands");
        $this->db->join("IMAGENES_ARTICULOS as ima", "products.id = ima.ARTICULO_ID", "left");        
        $this->db->join("G_Analytics as ga", "products.id = ga.product_id", "left");

        if (!empty($user)) {
            if (!empty($user->LOCALIDAD_ID)) {
                $this->db->select('claf.PCTJ_FLETE');
                $this->db->join("_CONFIG_LOC_ART_FL as claf", " products.tipo_articulo_flete = claf.TIPO_ARTICULO");
                $this->db->join("_LOCALIDADES as l", "claf.TIPO_LOCALIDAD = l.TIPO_LOCALIDAD OR l.TIPO_LOCALIDAD is null");
                $this->db->where('l.LOCALIDAD_ID', $user->LOCALIDAD_ID);
            }
        }
        if ($joinRoles) {
            $this->db->join("ROLES_IMAGENES_ARTICULOS as ria", "ima.ROL_IMAGEN_ART_ID = ria.ROL_IMAGEN_ART_ID AND ria.ROL_IMAGEN_ART_ID = 104132459");
        }
        
        $this->db->where("products.brand_id = brands.id", null, null);
        // $this->db->where("products.category_id", $id_categoria);
        //$this->db->where("G_Analytics.category_id", $id_categoria);
        if (!empty($agrupador)) {
            $this->db->where('products.articulo_eq_id', $agrupador);
            if (!empty($exclude)) {
                $this->db->where('products.id <>', $exclude);
            }
            
        }        
        
        // $this->db->where('ria.ROL_IMAGEN_ART_ID', 104132459);
        $this->db->group_by("products.id");
        $this->db->order_by("products.orden_catalogo", "ASC");

        $query = $this->db->get();
        // echo "<pre>";
        // print_r($query);
        // echo $this->db->last_query();
        // exit();
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    /**
     * Validamos si el producto contiene equivalentes
     */
    function check_equivalents ($product_id) {
        
        $this->db->select('EQUIVALENTES.ARTICULO_EQ_ID');
        $this->db->from('EQUIVALENTES');
        $this->db->where('ARTICULO_ID', $product_id);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function increment_product_stats($id_product, $newViews, $newAdds, $newPurchases)
    {
        $this->db->select("ga.*");
        $this->db->from("G_Analytics ga");
        $this->db->where("ga.product_id", $id_product);
        //$this->db->where("ga.id", $id_product);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->db->where("id", $row->id);
            $newViewsTotal = $row->views + $newViews;
            $newPurchasesTotal = $row->purchases + $newPurchases;
            $this->db->set('views', $newViewsTotal);
            $this->db->set('adds', $row->adds + $newAdds);
            $this->db->set('purchases', $newPurchasesTotal);
            $this->db->update('G_Analytics');
        } else {
            //$this->db->set('id', $id_product);
            $this->db->set('product_id', $id_product);
            $this->db->set('views', $newViews);
            $this->db->set('adds', $newAdds);
            $this->db->set('purchases', $newPurchases);
            $this->db->insert('G_Analytics');
        }

        return true;
    }

    function increment_category_stats($id_category)
    {
        $this->db->select("ga.*");
        $this->db->from("G_Analytics ga");
        $this->db->where("ga.category_id", $id_category);
        //$this->db->where("ga.id", $id_category);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->db->where("id", $row->id);
            $newViewsTotal = $row->views + 1;
            $this->db->set('views', $newViewsTotal);
            $this->db->update('G_Analytics');
        } else {
            //$this->db->set('id', $id_category);
            $this->db->set('category_id', $id_category);
            $this->db->set('views', 1);
            $this->db->insert('G_Analytics');
        }

        return true;
    }

    function increment_product_stats_in_order($order_id)
    {

        $this->db->select("p.id as product_id");
        $this->db->from("pedidos_web2 pw");
        $this->db->where("pw.pedidos_web_id", $order_id);

        $this->db->join("pedidos_web_detalle as pwd", "pwd.pedido_web_id = pw.pedidos_web_id");
        $this->db->join("products as p", "pwd.ARTICULO_ID = p.id");

        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $row) {
                $this->increment_product_stats($row->product_id, 0, 0, 1);
            }
        }
    }

    function saveReview($orderId, $rating, $comments)
    {
        $this->db->select("wr.*");
        $this->db->from("web_review wr");
        $this->db->where("wr.pedidos_web_id", $orderId);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->db->where("id", $row->id);
            $this->db->set('rating', $rating);
            $this->db->set('comments', $comments);
            $this->db->update('web_review');
        } else {
            $this->db->set('pedidos_web_id', $orderId);
            $this->db->set('rating', $rating);
            $this->db->set('comments', $comments);
            $this->db->insert('web_review');
        }
    }

    function get_product($id_product)
    {
        $user = (isset($this->data['user']) && !empty($this->data['user'])) ? $this->data['user'] : null;
        $this->db->select("products.*, brands.clave as 'brand_clave',brands.name as 'brand_name', gd.division_id, ga.views, ga.adds, ga.purchases");
        $this->db->from("products, brands");
        $this->db->join("groups_divisions as gd", " gd.category_id = products.category_id");
        $this->db->join("G_Analytics as ga", "products.id = ga.product_id", "left");
        if (!empty($user)) {
            if ($user->LOCALIDAD_ID) {
                $this->db->select('claf.PCTJ_FLETE');
                $this->db->join("_CONFIG_LOC_ART_FL as claf", " products.tipo_articulo_flete = claf.TIPO_ARTICULO");
                $this->db->join("_LOCALIDADES as l", "claf.TIPO_LOCALIDAD = l.TIPO_LOCALIDAD OR l.TIPO_LOCALIDAD is null");
                $this->db->where('l.LOCALIDAD_ID', $user->LOCALIDAD_ID);
            }
        }
        //$this->db->join("brands as bd", " bd.id = products.brand_id");

        $this->db->where("products.brand_id = brands.id", null, null);
        $this->db->where("products.id", $id_product);
        $this->db->order_by("products.orden_catalogo", "ASC");
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row() : [];
    }

    function get_product_caracteristics($id_product)
    {
        $this->db->select("CARACTERISTICAS_ARTS.CARACTERISTICA");
        $this->db->from("CARACTERISTICAS_ARTS");
        $this->db->where("CARACTERISTICAS_ARTS.ARTICULO_ID", $id_product);
        $this->db->group_by("CARACTERISTICAS_ARTS.CARACTERISTICA_ID");
        $this->db->order_by("CARACTERISTICAS_ARTS.ORDEN", "ASC");
        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function get_product_info($id_product)
    {
        $this->db->select("i.INFO_ARTICULO_ID as info_id");
        $this->db->select("i.INFORMACION as info");
        $this->db->from("INFORMACION_ARTS as i");
        $this->db->where("i.ARTICULO_ID", $id_product);
        $this->db->order_by("i.ORDEN", "ASC");

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function get_product_images($id_product)
    {
        $this->db->select("IMAGENES_ARTICULOS.IMAGEN_ARTICULO_ID as 'imageId'");
        $this->db->from("IMAGENES_ARTICULOS");
        $this->db->join('ROLES_IMAGENES_ARTICULOS ria', 'IMAGENES_ARTICULOS.ROL_IMAGEN_ART_ID = ria.ROL_IMAGEN_ART_ID');
        $this->db->where("IMAGENES_ARTICULOS.ARTICULO_ID", $id_product);
        $this->db->order_by("ria.ORDEN", "ASC");
        $query = $this->db->get();
        // echo $this->db->last_query();
        // exit();
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function get_divisions()
    {
        $this->db->select("d.id", FALSE);
        $this->db->join("groups_divisions as gd", "gd.division_id = d.id");
        $this->db->join("groups as g", "gd.group_id = g.id");
        $this->db->order_by("g.orden_catalogo asc,d.clave asc");
        $this->db->group_by(["g.id", "d.id"]);
        $query = $this->db->get('divisions as d');
        return ($query->num_rows() > 0) ? $query->result() : [];
    }
    function get_division($id_division)
    {
        $this->db->select("d.id,name", FALSE);
        $this->db->where("d.id", $id_division);
        $query = $this->db->get('divisions as d');
        return ($query->num_rows() > 0) ? $query->row() : [];
    }
    function divisions()
    {
        $this->db->select("d.name, g.cmyk_color,d.id, gd.group_id");
        $this->db->join("groups_divisions as gd", "gd.division_id = d.id");
        $this->db->join("groups as g", "g.id = gd.group_id");
        $this->db->order_by("g.orden_catalogo asc,d.name asc");
        $this->db->group_by("d.id");
        $query = $this->db->get("divisions as d");
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function divisionsFiltered($busqueda, $brands, $categories, $groups, $lines)
    {
        $this->db->select("dvs.name, dvs.id");
        $this->db->from("products as p");
        $this->db->join("groups_divisions as gd", " gd.category_id = p.category_id");
        $this->db->join("divisions as dvs", " dvs.id = gd.division_id");

        if (!empty($busqueda)) {
            $aKeyword = self::cleanSearchInput($busqueda);

            $this->db->join("INFORMACION_ARTS as i", "i.ARTICULO_ID = p.id", "left");
            $this->db->join("categories as c", "c.id = gd.category_id");
            $this->db->join("brands as b", "b.id = p.brand_id");
            $this->db->join("groups as gp", " gp.id = p.group_id", "left"); //grupos o departamentos
            $this->db->join("ARTICULOS_GIROS as gr", " gr.ARTICULO_ID = p.id");
            $this->db->join("BR_GIROS as bgr", " bgr.giro_id = gr.GIRO_ID");

            $this->db->like("c.name", $aKeyword[0], "both");
            $this->db->or_like("p.details", $aKeyword[0], "both");
            $this->db->or_like("p.product_code", $aKeyword[0], "both");
            $this->db->or_like("p.codigo", $aKeyword[0], "both");
            $this->db->or_like("p.ofb", $aKeyword[0], "both");
            $this->db->or_like("i.INFORMACION", $aKeyword[0], "both");
            $this->db->or_like("b.name", $aKeyword[0], "both"); //nombre de marca
            $this->db->or_like("bgr.nombre", $aKeyword[0], "both"); //nombre de giro
            $this->db->or_like("gp.nombre_etiqueta", $aKeyword[0], "both"); //nombre de grupo o departamento
            $this->db->or_like("dvs.name", $aKeyword[0], "both"); //nombre de division

            for ($i = 1; $i < count($aKeyword); $i++) {
                if (!empty($aKeyword[$i])) {
                    $word = str_replace(self::$nullKeyword[$i], " ", $aKeyword[$i]);
                    $this->db->or_like("p.details", $word, "both");
                    $this->db->or_like("p.product_code", $word, "both");
                    $this->db->or_like("p.codigo", $word, "both");
                    $this->db->or_like("c.name", $word, "both");
                    $this->db->or_like("p.ofb", $word, "both");
                    $this->db->or_like("i.INFORMACION", $word, "both");
                    $this->db->or_like("b.name", $word, "both"); //nombre de marca
                    $this->db->or_like("bgr.nombre", $word, "both"); //nombre de giro
                    $this->db->or_like("gp.nombre_etiqueta", $word, "both"); //nombre de grupo o departamento
                    $this->db->or_like("dvs.name", $word, "both"); //nombre de division

                }
            }
        }

        if (!empty($lines)) {
            if (empty($busqueda)) {
                $this->db->join("ARTICULOS_GIROS as gr", " gr.ARTICULO_ID = p.id");
            }
            $this->db->where_in("gr.GIRO_ID", $lines);
        }

        if (!empty($groups)) {
            $this->db->where_in("p.group_id", $groups);
        }

        if (!empty($brands)) {
            $this->db->where_in("p.brand_id", $brands);
        }

        $this->db->order_by("dvs.name", "asc");
        $this->db->group_by("dvs.id");

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function divisions_pagination_order()
    {
        $this->db->select("d.name, g.cmyk_color,d.id, gd.group_id");
        $this->db->join("groups_divisions as gd", "gd.division_id = d.id");
        $this->db->join("groups as g", "gd.group_id = g.id");
        $this->db->order_by("g.orden_catalogo asc,d.clave asc");
        $this->db->group_by(["g.id", "d.id"]);
        $query = $this->db->get('divisions as d');
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function categories()
    {
        $this->db->select("c.*,gd.division_id");
        $this->db->join("groups_divisions as gd", "gd.category_id = c.id");
        $this->db->order_by("c.name");
        $this->db->group_by("c.id");
        $query = $this->db->get("categories as c");
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function business_lines()
    {
        $this->db->select("g.nombre as name, g.giro_id as id");
        $this->db->order_by("g.nombre asc");
        $query = $this->db->get("BR_GIROS as g");
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function get_business_line($lineId)
    {
        $this->db->select("g.nombre as name, g.giro_id as id");
        $this->db->order_by("g.nombre asc");
        $this->db->where("g.giro_id", $lineId);
        $query = $this->db->get("BR_GIROS as g");
        return ($query->num_rows() > 0) ? $query->row() : [];
    }

    function linesFiltered($busqueda, $divisions, $categories, $groups, $brands)
    {

        if (empty($busqueda) && empty($groups) && empty($divisions) && empty($brands)) {
            $this->db->select("gr.giro_id as id, gr.nombre as name");
            $this->db->from("BR_GIROS as gr");
            $this->db->order_by("gr.nombre", "asc");
            $this->db->group_by("gr.giro_id");
        } else {
            $this->db->select("bgr.giro_id as id, bgr.nombre as name");
            $this->db->from("products as p");
            $this->db->join("ARTICULOS_GIROS as ag", " ag.ARTICULO_ID = p.id");
            $this->db->join("BR_GIROS as bgr", " bgr.giro_id = ag.GIRO_ID");

            if (!empty($busqueda)) {
                $aKeyword = self::cleanSearchInput($busqueda);

                $this->db->join("INFORMACION_ARTS as i", "i.ARTICULO_ID = p.id", "left");
                $this->db->join("groups_divisions as gd", " gd.category_id = p.category_id");
                $this->db->join("categories as c", "c.id = gd.category_id");
                $this->db->join("divisions as dvs", " dvs.id = gd.division_id"); //divisiones
                $this->db->join("brands as b", "b.id = p.brand_id");
                $this->db->join("groups as gp", " gp.id = p.group_id", "left"); //grupos o departamentos

                $this->db->like("c.name", $aKeyword[0], "both");
                $this->db->or_like("p.details", $aKeyword[0], "both");
                $this->db->or_like("p.product_code", $aKeyword[0], "both");
                $this->db->or_like("p.codigo", $aKeyword[0], "both");
                $this->db->or_like("p.ofb", $aKeyword[0], "both");
                $this->db->or_like("i.INFORMACION", $aKeyword[0], "both");
                $this->db->or_like("b.name", $aKeyword[0], "both"); //nombre de marca
                $this->db->or_like("bgr.nombre", $aKeyword[0], "both"); //nombre de giro
                $this->db->or_like("gp.nombre_etiqueta", $aKeyword[0], "both"); //nombre de grupo o departamento
                $this->db->or_like("dvs.name", $aKeyword[0], "both"); //nombre de division

                for ($i = 1; $i < count($aKeyword); $i++) {
                    if (!empty($aKeyword[$i])) {
                        $word = str_replace(self::$nullKeyword[$i], " ", $aKeyword[$i]);
                        $this->db->or_like("p.details", $word, "both");
                        $this->db->or_like("p.product_code", $word, "both");
                        $this->db->or_like("p.codigo", $word, "both");
                        $this->db->or_like("c.name", $word, "both");
                        $this->db->or_like("p.ofb", $word, "both");
                        $this->db->or_like("i.INFORMACION", $word, "both");
                        $this->db->or_like("b.name", $word, "both"); //nombre de marca
                        $this->db->or_like("bgr.nombre", $word, "both"); //nombre de giro
                        $this->db->or_like("gp.nombre_etiqueta", $word, "both"); //nombre de grupo o departamento
                        $this->db->or_like("dvs.name", $word, "both"); //nombre de division

                    }
                }
            }
            if (!empty($groups)) {
                $this->db->where_in("p.group_id", $groups);
            }

            if (!empty($divisions)) {
                if (empty($busqueda)) {
                    $this->db->join("groups_divisions as gd", " gd.category_id = p.category_id");
                }
                $this->db->where_in("gd.division_id", $divisions);
            }

            if (!empty($brands)) {
                $this->db->where_in("p.brand_id", $brands);
            }

            $this->db->order_by("bgr.nombre", "asc");
            $this->db->group_by("bgr.giro_id");
        }


        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function get_brand($brandId)
    {
        $this->db->select("brands.id, brands.name");
        $this->db->from("brands");
        $this->db->where("brands.id", $brandId);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->row() : [];
    }

    function brands()
    {
        $this->db->order_by("name");
        $query = $this->db->get("brands");
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function brandsFiltered($busqueda, $divisions, $categories, $groups, $lines)
    {

        if (empty($busqueda) && empty($groups) && empty($divisions) && empty($lines)) {
            $this->db->select("b.id, b.name");
            $this->db->from("brands as b");
            $this->db->order_by("b.name", "asc");
        } else {
            $this->db->select("b.id, b.name");
            $this->db->from("products as p");
            $this->db->join("brands as b", "b.id = p.brand_id");

            if (!empty($busqueda)) {
                $aKeyword = self::cleanSearchInput($busqueda);

                $this->db->join("INFORMACION_ARTS as i", "i.ARTICULO_ID = p.id", "left");
                $this->db->join("groups_divisions as gd", " gd.category_id = p.category_id");
                $this->db->join("categories as c", "c.id = gd.category_id");
                $this->db->join("groups as gp", " gp.id = p.group_id", "left"); //grupos o departamentos
                $this->db->join("divisions as dvs", " dvs.id = gd.division_id"); //divisiones
                $this->db->join("ARTICULOS_GIROS as gr", " gr.ARTICULO_ID = p.id", "left");
                $this->db->join("BR_GIROS as bgr", " gr.GIRO_ID = bgr.giro_id", "left"); //giros

                $this->db->like("c.name", $aKeyword[0], "both");
                $this->db->or_like("p.details", $aKeyword[0], "both");
                $this->db->or_like("p.product_code", $aKeyword[0], "both");
                $this->db->or_like("p.codigo", $aKeyword[0], "both");
                $this->db->or_like("p.ofb", $aKeyword[0], "both");
                $this->db->or_like("i.INFORMACION", $aKeyword[0], "both");
                $this->db->or_like("b.name", $aKeyword[0], "both"); //nombre de marca
                $this->db->or_like("bgr.nombre", $aKeyword[0], "both"); //nombre de giro
                $this->db->or_like("gp.nombre_etiqueta", $aKeyword[0], "both"); //nombre de grupo o departamento
                $this->db->or_like("dvs.name", $aKeyword[0], "both"); //nombre de division

                for ($i = 1; $i < count($aKeyword); $i++) {
                    if (!empty($aKeyword[$i])) {
                        $word = str_replace(self::$nullKeyword[$i], " ", $aKeyword[$i]);
                        $this->db->or_like("p.details", $word, "both");
                        $this->db->or_like("p.product_code", $word, "both");
                        $this->db->or_like("p.codigo", $word, "both");
                        $this->db->or_like("c.name", $word, "both");
                        $this->db->or_like("p.ofb", $word, "both");
                        $this->db->or_like("i.INFORMACION", $word, "both");
                        $this->db->or_like("b.name", $word, "both"); //nombre de marca
                        $this->db->or_like("bgr.nombre", $word, "both"); //nombre de giro
                        $this->db->or_like("gp.nombre_etiqueta", $word, "both"); //nombre de grupo o departamento
                        $this->db->or_like("dvs.name", $word, "both"); //nombre de division

                    }
                }
            }

            if (!empty($groups)) {
                $this->db->where_in("p.group_id", $groups);
            }
            if (!empty($divisions)) {
                if (empty($busqueda)) {
                    $this->db->join("groups_divisions as gd", " gd.category_id = p.category_id");
                }
                $this->db->where_in("gd.division_id", $divisions);
            }

            if (!empty($lines)) {
                if (empty($busqueda)) {
                    $this->db->join("ARTICULOS_GIROS as gr", " gr.ARTICULO_ID = p.id");
                }
                $this->db->where_in("gr.GIRO_ID", $lines);
            }

            $this->db->order_by("b.name", "asc");
            $this->db->group_by("p.brand_id");
        }

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function groupsFiltered($busqueda, $divisions, $categories, $lines, $brands)
    {
        if (empty($busqueda) && empty($brands) && empty($divisions) && empty($lines)) {
            $this->db->select("g.id, g.nombre_etiqueta as name, g.url_image as image");
            $this->db->from("groups as g");
            $where = "nombre_etiqueta IS NOT NULL";

            $this->db->where($where);
            $this->db->order_by("g.nombre_etiqueta", "asc");
        } else {
            $this->db->select("gp.id, gp.nombre_etiqueta as name, gp.url_image as image");
            $this->db->from("products as p");
            $this->db->join("groups as gp", "gp.id = p.group_id");

            if (!empty($busqueda)) {
                $aKeyword = self::cleanSearchInput($busqueda);

                $this->db->join("INFORMACION_ARTS as i", "i.ARTICULO_ID = p.id", "left");
                $this->db->join("groups_divisions as gd", " gd.category_id = p.category_id");
                $this->db->join("categories as c", "c.id = gd.category_id");
                $this->db->join("divisions as dvs", " dvs.id = gd.division_id"); //divisiones
                $this->db->join("ARTICULOS_GIROS as gr", " gr.ARTICULO_ID = p.id", "left");
                $this->db->join("BR_GIROS as bgr", " gr.GIRO_ID = bgr.giro_id", "left"); //giros
                $this->db->join("brands as b", "b.id = p.brand_id");

                $this->db->like("c.name", $aKeyword[0], "both");
                $this->db->or_like("p.details", $aKeyword[0], "both");
                $this->db->or_like("p.product_code", $aKeyword[0], "both");
                $this->db->or_like("p.codigo", $aKeyword[0], "both");
                $this->db->or_like("p.ofb", $aKeyword[0], "both");
                $this->db->or_like("i.INFORMACION", $aKeyword[0], "both");
                $this->db->or_like("b.name", $aKeyword[0], "both"); //nombre de marca
                $this->db->or_like("bgr.nombre", $aKeyword[0], "both"); //nombre de giro
                $this->db->or_like("gp.nombre_etiqueta", $aKeyword[0], "both"); //nombre de grupo o departamento
                $this->db->or_like("dvs.name", $aKeyword[0], "both"); //nombre de division

                for ($i = 1; $i < count($aKeyword); $i++) {
                    if (!empty($aKeyword[$i])) {
                        $word = str_replace(self::$nullKeyword[$i], " ", $aKeyword[$i]);
                        $this->db->or_like("p.details", $word, "both");
                        $this->db->or_like("p.product_code", $word, "both");
                        $this->db->or_like("p.codigo", $word, "both");
                        $this->db->or_like("c.name", $word, "both");
                        $this->db->or_like("p.ofb", $word, "both");
                        $this->db->or_like("i.INFORMACION", $word, "both");
                        $this->db->or_like("b.name", $word, "both"); //nombre de marca
                        $this->db->or_like("bgr.nombre", $word, "both"); //nombre de giro
                        $this->db->or_like("gp.nombre_etiqueta", $word, "both"); //nombre de grupo o departamento
                        $this->db->or_like("dvs.name", $word, "both"); //nombre de division

                    }
                }
            }

            if (!empty($brands)) {
                $this->db->where_in("p.brand_id", $brands);
            }

            if (!empty($divisions)) {
                if (empty($busqueda)) {
                    $this->db->join("groups_divisions as gd", " gd.category_id = p.category_id");
                }
                $this->db->where_in("gd.division_id", $divisions);
            }

            if (!empty($lines)) {
                if (empty($busqueda)) {
                    $this->db->join("ARTICULOS_GIROS as gr", " gr.ARTICULO_ID = p.id");
                }
                $this->db->where_in("gr.GIRO_ID", $lines);
            }
            $where = "nombre_etiqueta IS NOT NULL";

            $this->db->where($where);
            $this->db->order_by("gp.nombre_etiqueta", "asc");
            $this->db->group_by("p.group_id");
        }


        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function get_group($groupId)
    {
        $this->db->select("groups.id, groups.nombre_etiqueta as name");
        $this->db->from("groups");
        $this->db->where("groups.id", $groupId);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->row() : [];
    }

    function controls_paginate($busqueda, $divisions, $categories, $brands)
    {
        //Eliminamos las palabras no permitidas
        for ($i = 0; $i < count(self::$nullKeyword); $i++) {
            $busqueda = str_replace(self::$nullKeyword[$i], " ", $busqueda);
        }

        $aKeyword = explode(" ", $busqueda);

        $this->db->select("count(*) as products_like,gd.division_id, gd.category_id, p.brand_id");
        $this->db->from("products as p");
        $this->db->join("groups_divisions as gd", " gd.category_id = p.category_id");
        $this->db->join("categories as c", "c.id = gd.category_id");
        if (!empty($busqueda)) {
            // $this->db->like("p.details",$busqueda,"both");
            // $this->db->or_like("p.product_code",$busqueda,"both");
            // $this->db->or_like("c.name",$busqueda,"both");
            $this->db->like("p.details", $aKeyword[0], "both");
            $this->db->or_like("p.product_code", $aKeyword[0], "both");
            $this->db->or_like("c.name", $aKeyword[0], "both");

            for ($i = 1; $i < count($aKeyword); $i++) {
                if (!empty($aKeyword[$i])) {
                    $word = str_replace(self::$nullKeyword[$i], " ", $aKeyword[$i]);
                    $this->db->or_like("p.details", $word, "both");
                    $this->db->or_like("p.product_code", $word, "both");
                    $this->db->or_like("c.name", $word, "both");
                }
            }
        }
        $this->db->group_by("gd.category_id");
        $this->db->get();
        $subquery = $this->db->last_query();
        // print_r($subquery);
        $products_like = "";
        if (!empty($busqueda) || !empty($categories) || !empty($brands)) {
            $products_like = ",p.products_like";
        }
        $this->db->select("c.name, c.id as category_id, gd.division_id" . $products_like);
        $this->db->from("categories as c ");
        $this->db->join("groups_divisions as gd", "gd.category_id = c.id ");
        $this->db->join("groups as g", "g.id =gd.group_id ");
        $this->db->join("divisions as d", "d.id = gd.division_id ");
        if (!empty($busqueda) || !empty($categories) || !empty($brands)) {
            $this->db->join(
                "(" . $subquery . ") as p",
                "p.category_id = c.id"
            );
            $this->db->where("p.products_like > 0", null, null);
        }
        if (!empty($categories)) {
            $this->db->where_in("c.id", $categories);
        }
        if (!empty($brands)) {
            $this->db->where_in("p.brand_id", $brands);
        }
        if (!empty($divisions)) {
            $this->db->where_in("d.id", $divisions);
        }
        $this->db->order_by("g.orden_catalogo asc,d.clave asc, c.orden_catalogo asc");
        $this->db->group_by("gd.category_id");
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    /**
     * Funtion: Obtener los grupos de divisiones para poder paginar de acuerdo al color
     * view: Index
     * Controller: Catalogo_nuevo
     * Date: 14/07/2020
     * By: Cesar Chab
     */
    function getGroupsByDivisions()
    {
        $query = "SELECT g.id, g.nombre_etiqueta AS name, g.cmyk_color as color, d.id AS division_id, g.url_image FROM groups g 
        INNER JOIN groups_divisions gd ON g.id = gd.group_id 
        INNER JOIN divisions d ON gd.division_id = d.id 
        WHERE g.id <> 103609915
        GROUP BY g.id ORDER BY g.nombre_etiqueta asc ";
        $query = $this->db->query($query);
        return ($query->num_rows() > 0) ? $query->result() : [];
    }

    function busqueda_avanzada($frase, $tipo_busqueda, $filtar = true, $campoBD, $debug = true)
    {

        if ($debug) {
            echo "<h1>La frase original <font color=red>$frase</font></h1>";
        }

        //comprobamos que han escrito una frase.

        if (trim($frase) == "") { //el campo esta vacio.
            return false; // no devolvemos nada
        } else { //
            $frase = mb_strtolower(trim($frase), 'UTF-8');
            // filtramos las palabras 
            if ($filtar) {
                $palabras_nulas = array(" y ", " de ", " para ", " por ", " o ", " a ", "  ", "   ", "", " las ", " los ");
                //Eliminamos las palabras no permitidas
                for ($i = 0; $i < count($palabras_nulas); $i++) {
                    $frase = str_replace($palabras_nulas[$i], " ", $frase);
                    $frase_filtrada = $frase;
                }
                if ($debug) {
                    echo "<h2><font color=blue>He seleccionado filtrar buscaremos 
      <font color=red>$frase_filtrada</font></font></h2>";
                }
            } else { //No se ha seleccionado filtrar
                $frase_filtrada = $frase;
                if ($debug) {
                    echo "<h2><font color=blue>He seleccionado NOOOOOOO filtrar 
      buscaremos <font color=red>$frase_filtrada</font></font></h2>";
                }
            }

            //segunda parte tipo de busquedad
            $string_busqueda = "WHERE (";
            switch ($tipo_busqueda) {
                case 'T1':
                    $string_busqueda .= " $campoBD like '%$frase_filtrada%'    "; //hay que dejar 4 espacios
                    $tipo_busqueda = "FRASE EXACTA";
                    break;
                case 'T2':
                    $frase_enpalabras = explode(" ", $frase);
                    for ($i = 0; $i < count($frase_enpalabras); $i++) {
                        $string_busqueda .= $campoBD . " LIKE '%" . $frase_enpalabras[$i] . "%' OR  ";
                    }
                    $tipo_busqueda = "CUALQUIER PALABRA";
                    break;
                case 'T3':
                    $frase_enpalabras = explode(" ", $frase);
                    for ($i = 0; $i < count($frase_enpalabras); $i++) {
                        $string_busqueda .= $campoBD . " LIKE '%" . $frase_enpalabras[$i] . "%' AND ";
                    }
                    $tipo_busqueda = "TODAS LAS PALABRAS";
                    break;
            }

            $string_busqueda = substr_replace($string_busqueda, "", -4);
            $string_busqueda .= ')';

            if ($debug) {
                echo "<h3><font color=blue>He seleccionado $tipo_busqueda el filtro queda
                  <font color=green>$string_busqueda</font></font></h3>";
            }
        } //end primer if

        echo $string_busqueda;
    } //end function


}
