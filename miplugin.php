<?php
/**
* Plugin Name: miplugin
* Plugin URI: https://consultorweb.cl
* Description: Muestra todas las categorias.
* Version: 1.0.0
* Author: Cristopher Munoz
* Author URI: http://consultorweb.cl
* License: GPL2
*/


add_filter( 'the_content', 'cc_post_relacionado');

if(!function_exists("cc_post_relacionado")){
	function cc_post_relacionado($content){
		if(!is_singular('post')){
			return "contenido:".$content;
		}else{
			$categorias = get_the_terms(get_the_ID(),"category"); //obtengo categoria
			$array=array();
			foreach ($categorias as $categoria) {
				$array[] = $categoria->term_id;
			}

			$loop = new Wp_Query
			(
				array
				(
					'category_in'=>$array,
					'posts_per_page' => 2,
					'post_not_in' => array(get_the_ID()),
					'orderby' => 'rand'
				)
			);
			if($loop->have_posts())
			{
				$content.="Post de la categoria";
				$content.="<hr/>";
				$content.="<ul>";
					while($loop->have_posts()) {
						$loop->the_post();
						$content.='<li>';
						$content.= '<a href="'.get_permalink().'">Ir a la entrada: '.get_the_title().'</a>';
						$content.="</li>";
					}
				$content.="</ul>";
			}
			//print_r($array);
			return $content;
		}
	}
}

