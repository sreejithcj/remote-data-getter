jQuery(document).ready(function( $ ) {
    let url = ajax.pluginsUrl + '/wp-json/wpc/v1/employees/';
    fetch(url, {
      headers: new Headers(
        {"Authorization": `Basic cmR1c2VyMjAyMDpyZDY1NGF3ZXIyMDIw`}
      ),
    }).then(response => {
      return response.json();
    }).then(data => {
      let template = "";
      if( data.status != 200 ) { 
        template = wp.template( 'error-template' );
        $('#remote-data-section').html(template( { status: data.status, message: data.response } ) );
      } 
      else {
        template = wp.template( 'data-template' );
        let content = (JSON.parse(data.body_response)).data;
        $('#remote-data-section').html(template( content ) );
      }
    });
  }); 