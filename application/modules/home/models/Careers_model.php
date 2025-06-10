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

class Careers_model extends MY_Model
{

    /**
     * @param string $cond
     * @param $limit
     * @param string $field
     * @return mixed
     */
    function getCareers($con)
    {
        $sql = "SELECT blog_id, date_add, career_effect, career_expire, slug, title, short, price 
FROM view_careers
where career_expire >= date(now()) $con";
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param string $cond
     * @param string $limit
     * @param string $field
     * @return mixed
     */
    function getCareersBy(
        $cond = '',
        $field = " * "
    )
    {
        $sql = "SELECT $field FROM view_careers WHERE $cond ORDER BY date_add DESC";
        return $this->db->query($sql)->row_array();
    }

}
