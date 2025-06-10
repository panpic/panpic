<?php
/**
 * Model Front-end
 * Last update 15 Jun 2020
 *
 * @package Front-end
 * @copyright PANPIC
 * @author @contact@panpic.vn
 * @author position: PHP Developer
 * @since 15 Jun 2020
 */


class Search_model extends MY_Model
{

    /**
     * @param $keyword
     * @param $lang
     * @param int $num
     * @param int $offset
     * @param string $select
     * @return mixed
     */
    function getKeyWordPagination($keyword, $lang, $num = 0, $offset = 0, $select = 'blog_id, title, slug, path_image, path_image_thumb, date_add, c.cat_name, c.cat_slug ')
    {
        $limit = ($num > 0) ? " LIMIT $offset,$num " : '';
        $blog = $select . ', post_type';
        $portfolio = $select . ', "P" as post_type';

        $sql = "select $blog from view_blog AS a
            JOIN view_category AS c ON a.category_id = c.post_cat_id
            where a.post_type = 'B' and MATCH(a.title) AGAINST('$keyword') AND a.content IS NOT NULL AND a.content != ''
            union
            select $portfolio from view_portfolio AS b
            JOIN view_category AS c ON b.category_id = c.post_cat_id
            where MATCH(title) AGAINST('$keyword') AND content IS NOT NULL AND content != ''
            ORDER BY date_add DESC $limit";

        return $this->db->query($sql)->result_array();
    }

    /**
     * @param string $cond
     * @return mixed
     */
    function getKeyWordTotal($keyword, $lang, $select = 'blog_id')
    {

        $sql = "select $select from view_blog where post_type = 'B' and MATCH(title) AGAINST('$keyword') AND content IS NOT NULL AND content != ''
                union
                select $select from view_portfolio where MATCH(title) AGAINST('$keyword') AND content IS NOT NULL AND content != ''";

        return $this->db->query($sql)->result_array();
    }

}
