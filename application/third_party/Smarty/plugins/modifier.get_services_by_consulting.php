<?php
function smarty_modifier_get_services_by_consulting($consulting_id)
{
    $ci = &get_instance();
    $ci->load->model('consulting_model');
    return $ci->consulting_model->getServicesByConsulting($consulting_id);
    
}
