<?php

/**
 * Récupère le paramètre d'un user
 * 
 * @param int $users_id
 * @param string $parameter
 * @return object / bool
 */
function getUserParameter($users_id, $parameter) {
    $ci = get_instance();
    $parameter = $ci->users_parameters->getParameter($users_id, $parameter);
    if ($parameter) {
        return $parameter->users_parameters_value;
    } else {
        return false;
    }
}

/**
 * Return user role
 * @return string
 */
function getRole() {
    $ci = get_instance();
    return $ci->session->userdata('role');
}

/**
 * If not logged > logout
 */
function checkIsLogged() {
    $ci = get_instance();
    if (!$ci->session->userdata('id')) {
        redirect(base_url('admin?notif=logout_complete'));
    }
}

/**
 * Check if user is autorised to go after this function
 * 
 * @param array $accepted
 */
function checkPermission($accepted = array()) {
    if (!in_array(getRole(), $accepted)) {
        switch (getRole()) {
            case 'customer_hiboutik' :
                redirect(base_url('app/users'));
                break;
            default :
                redirect(base_url('app/dashboard'));
                break;
        }
    }
}

/**
 * Functions helper
 */
function paginationConfig() {
    $config['full_tag_open'] = '<nav>';
    $config['full_tag_close'] = '</nav>';
    $config['cur_tag_open'] = '<li><span class="page-numbers current">';
    $config['cur_tag_close'] = '</span></li>';
    $config['first_tag_open'] = $config['last_tag_open'] = $config['prev_tag_open'] = $config['next_tag_open'] = $config['num_tag_open'] = '<li class="page-numbers">';
    $config['first_tag_close'] = $config['last_tag_close'] = $config['prev_tag_close'] = $config['next_tag_close'] = $config['num_tag_close'] = '</li>';
    $config['first_link'] = '<<';
    $config['last_link'] = '>>';
    return $config;
}

/**
 * Gestion des notifications 
 * 
 * @param string $notif
 * @return array
 */
function getNotif($notif, $url = false) {
    $ci = get_instance();
    switch ($notif) {
        case 'unknown' :
        case 'unknown_error' :
            return array(
                'title' => 'Erreur inconnue !',
                'text' => 'Une erreur s\'est produite, merci de contacter l\'administrateur du site.',
                'class' => 'error'
            );
            break;
        default :
            return false;
            break;
    }
}


?>