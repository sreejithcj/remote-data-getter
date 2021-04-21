<?php

/**
 * Admin user page content to for "Manage Remote Data" menu item
 * @since      1.0.0
 * @author	Ruslan Ismailov
 */

declare( strict_types = 1 );

namespace RemoteDataGetter\Admin\Partials; 

use RemoteDataGetter\Inc as Common;

class Manage_Remote_Data 
{
    public function get_content(): string 
    {
        $content = $this->get_remote_data();
        return( 
            '<div class="wrap">
                <h1 class="wp-heading-inline">Manage Remote Data</h1>
                <h2 class="screen-reader-text">Manage Remote Data</h2>
                <div class="msg-settings"></div>
                <div class="tablenav">
                <div id="remote_data_message"></div>
                <form action="'.admin_url('admin-post.php') .'"method="post" name="rdg_purge_data_form">
                    <input type="hidden" name="action" value="purge_cache">
                    <input type="submit" id="submit" class="button button-primary" value="Purge Cache">'
                    .wp_nonce_field('rdg_purge_data_form', 'remote_data_nonce').
                '</form>
                <section id="remote-data-section">'.$content.'</section>
                </div>
            </div>');
    }
    /**
     * Consume the endpoint and format the response.
     */
    private function get_remote_data(): string 
    {
        $header = '';
        $tbody = '';
        $footer = '';
        

        $route = new Common\Routes();
        $response = $route->get_employee_data();

        if ( isset($response) ) {
            if( $response[1]!= 200 ) {
                $tbody = $this->generate_failed_response_html($response);
            } else {
                $response_body = json_decode($response[0],true );

                $employees =  (array_key_exists("data", $response_body))
                            ? $response_body["data"] 
                            : null;
                if( $employees ) {
                    $header = $this->generate_header();
                    $footer = $this->generate_footer();
                    $tbody = $this->generate_employee_html($employees);   
                }
            }
        }
        return $header.$tbody.$footer; 
    }

    /**
     * Generate table header section html
     */
    private function generate_header(): string 
    {
        $header = 
        '<table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Employee Name</th>
                <th scope="col">Salary</th>
                <th scope="col">Age</th>
            </tr>
            </thead>
            <tbody>';
        return $header;   
    }
    /**
     * Generate table footer section html
     */
    private function generate_footer(): string 
    {
        $footer = '</tbody></table>';
        return $footer;   
    }

    /**
     * Generate failed response html
     */
    private function generate_failed_response_html(array $response): string 
    {
        return 
        '<span>Failed to fetch data. Please find more details below <span>
        <p>Status code: '.esc_html($response[1]).'<br />Message: '.esc_html($response[2]).'</p>';
    }

    /**
     * Generate employee data html
     */
    private function generate_employee_html(array $employees): string 
    {
        $emp_html = '';
        foreach($employees as $employee) {
            $emp_html .= '<tr><th scope="row">'.esc_html($employee['id'])
            .'</th><td>'.esc_html($employee['employee_name'])
            .'</td><td>'.esc_html($employee['employee_salary'])
            .'</td><td>'.esc_html($employee['employee_age'])
            .'</td></tr>';
        }
        return $emp_html;
    }
}
