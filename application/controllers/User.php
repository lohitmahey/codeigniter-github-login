<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        //Loading helper functions
        $this->load->helper( array( 'url', 'api' ) );
        
        //$this->load->library( array( 'cookie', 'session' ) );
        $this->load->helper('cookie');
        //$this->load->helper('session');
    }
    
	public function index() {
        
        if( !get_cookie( 'git_access_token' ) ) {
            return redirect( 'user/login' );
        }
        
        /*
        if( !$this->session->has_userdata( 'git_access_token' ) ) {
            return redirect( 'user/login' );
        }
        */
        
        // $access_token = $this->session->userdata( 'git_access_token' );
        $access_token = get_cookie( "git_access_token" );
        
        //$url = 'https://api.github.com/user/repos';
        $url = 'https://api.github.com/repositories';
        //$url = 'https://api.github.com/user';
        
        $params = [];
        $headers = [
            'Authorization: token ' . $access_token,
            'User-Agent: ' . GIT_APP_NAME
        ];
        
        $allrepos = curl_request( $url, $headers, 'GET', $params );
        $total_repos = count( $allrepos );
        
        $owners = [];
        if( $total_repos == 0 ) {
            // No repos
        } else {
            // Create array of repos for grouping
            
            foreach( $allrepos as $key => $val ) {
                $owners[ $val[ 'owner' ][ 'login' ] ][] = $val;
            }
            
        }
        
		$this->load->view('repositories', array( 'owner_repos' => $owners ) );
	}
    
    /*
     * User login
     */
    public function login() {
        
        if( get_cookie( 'git_access_token' ) ) {
            return redirect( 'user' );
        }
        
		$this->load->view('login');
	}
    
    /*
     * Logout the user
     * Destroy the cookies
     */
    public function logout() {
        delete_cookie( 'git_access_token' );
        return redirect( 'user' );
    }
    
    /*
     * User login callback for github
     * Get the temporary code from git and do CURL post request to get access token
     */
    public function login_callback() {
        
        $code = $this->input->get( 'code' );
        
        $params = [
            'client_id' => GIT_APP_CLIENT_ID,
            'code' => $code,
            'client_secret' => GIT_APP_CLIENT_SECRET
        ];
        
        $curl_response = curl_request( GIT_AUTH_POST_CODE_URL, array(), 'POST', $params );
        
        if( isset( $curl_response[ 'access_token' ] ) ) {
            
            // Access is granted
            // $this->session->set_userdata( 'git_access_token',  $curl_response[ 'access_token' ] );
            
            $cookie= array(
                'name'   => 'git_access_token',
                'value'  => $curl_response[ 'access_token' ],
                'expire' => GIT_TOKEN_EXPIRE_IN_SECONDS
            );

            set_cookie($cookie);
            return redirect( 'user' );
        }
        
        // Return back to login page with error message
        $error_msg = isset( $curl_response[ 'error_description' ] ) ? $curl_response[ 'error_description' ] : $curl_response[ 'msg' ];
		$this->load->view( 'login', array( 'login_error' => $error_msg ) );
	}
    
    /*
     * Redirect to github login page
     */
    public function GET_gitlogin() {
        $url = GIT_AUTH_GET_CODE_URL . '?client_id=' . GIT_APP_CLIENT_ID;
        return redirect( $url );
    }
    
}