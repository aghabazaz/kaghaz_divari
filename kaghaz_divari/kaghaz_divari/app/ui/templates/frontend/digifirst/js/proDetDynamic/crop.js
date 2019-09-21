  
function round5(x)
{
    return (x % 5) >= 2.5 ? parseInt(x / 5) * 5 + 5 : parseInt(x / 5) * 5;
}

function handleChange(input) {
  	var is_table = jQuery('.calculator-wrapper').hasClass('is_tbl');

    if( input.value < 20 ) {
      
      alert('Minimum 20cm girmeniz gerekir.');
      if( input.name === 'room_width') {
          input.value = 20;
          jQuery(input).focus();
      }
      if( input.name === 'room_length') {
          input.value = 20;
          jQuery(input).focus();
      }      
    }
    if (is_table) {

        input.value = round5(input.value);
        /*İlk kutucuga veri girmekteyse ?*/
        if (input.name === 'room_width') {
            var room_length = jQuery('input[name="room_length"]');
            if (input.value > 200) {
                input.value = 200;
            }
            if (room_length.val() > 140 && input.value > 140) {
                input.value = 140;
            }
        }

        /*İkinci kutucuga veri girmekteyse ?*/
        if (input.name === 'room_length') {
            var room_width = jQuery('input[name="room_width"]');
            if (room_width.val() > 140 && input.value > 140) {
                input.value = 140;
                if (input.value < 20) {
                    input.value = 20;
                }
            }

            if (input.value > 200) {
                input.value = 200;
            }

        }

    }

}

jQuery(function($j){

  $j('body').on('click','.open_product_form',function(e){

    e.preventDefault();
    $j('.product_form').removeClass('hidden');
    $j(this).addClass('hidden');

    $j('.close_product_form').click(function(){
      $j('.product_form').addClass('hidden');
      $j('.open_product_form').removeClass('hidden');
    });

    $j('.send_product_form').click(function(ev){
      ev.preventDefault();
        var p_url = $j('input.product_url').val();
        var name = $j('input.sender_name').val();
        var phone = $j('input.sender_phone').val();
        var email = $j('input.sender_email').val();
        var width = $j('input.sender_width').val();
        var height = $j('input.sender_height').val();
        var message = $j('textarea.sender_message').val();
        var store_id = $j('input.store_id').val();

        if( p_url && name && email && width && height && message) {
          var form_control = 'ok';
          $j.ajax({
              async:true,
              url: "/ajax.php",
              type: "POST",
              cache:false,
              data :{ act: 'send_product_message', store_id:store_id, p_url:p_url, name:name, phone:phone,email:email, width:width, height:height, message:message, form_control:form_control },
              dataType: 'json',
              success: function(data)
              {
                alert('Mesajınız başarıyla alındı.');
                $j('.product_form').addClass('hidden');
                $j('.open_product_form').removeClass('hidden');
              },
              error: function (data)
              {
              }      
          });
        } else {
          alert('Lütfen tüm alanları doldurunuz.');
        }

    });
    
  });

  $j('.help_1 a').webuiPopover();

   $j.fn.cropper;
	 $j(function(){

    $j('body').on('change','#room_width, #room_length',function(){

            $j('img#image-main').removeClass('etalage_thumb_image').addClass('crop_image');

            if( $j('input#room_width').val().length > 0 &&  $j('input#room_length').val().length > 0 ) {

            	$j('input[name="grayscale"]').removeAttr('disabled');
            	$j('input[name="aspect_ratio"]').removeAttr('disabled');
            	$j('input[name="mirror"]').removeAttr('disabled');
            	/* Mirror */
					$j('input[name="mirror"]').change(function(){

							if ( this.checked ) {
								$crop.cropper('scale', -1, 1);
							} else {
								$crop.cropper('scale', 1, 1);
							}
					});  
				/* Mirror */

				/* Grayscale */
					$j('input[name="grayscale"]').change(function(){

						var json_data = $j('input.crop_image').val(); 	
						var json_data = JSON.parse( json_data );
							if ( this.checked ) {
								$j('span.cropper-view-box').addClass('grayscale');
								json_data['grayscale'] = 1;
							} else {
								$j('span.cropper-view-box').removeClass('grayscale');
								json_data['grayscale'] = 0;
							}

							$j('input.crop_image').val( JSON.stringify(json_data) ); 
					});  
				/* Grayscale */	

				/* Keep Aspect Ratio */
					$j('input[name="aspect_ratio"]').change(function(){
							var screenImage = $j("img#image-main");

							// Create new offscreen image to test
							var theImage = new Image();
							theImage.src = screenImage.attr("src");

							// Get accurate measurements from that.
							var _W = theImage.width;
							var _H = theImage.height;
							var oran = _W / _H;
							var h_ = $j('#room_length').val();

							$j('#room_width').val( (h_ * oran).toFixed(0) );
							if ( this.checked && $j('input#room_width').val().length > 0 &&  $j('input#room_length').val().length > 0 && $j('input#room_width').val() !== '0' &&  $j('input#room_length').val() !== '0' ) {

								ca.calcRoom();
			                    $crop = $j('img#image-main');
			                    //$crop.cropper('destroy');
			                    $crop.cropper('setAspectRatio', oran);
							} else {
			                    $crop = $j('img#image-main');
			                    $crop.cropper('destroy');	
			                    $j('#room_width').val(0);								
			                    $j('#room_length').val(0);								
							}
					});  
				/* Keep Aspect Ratio */											                  

                    $crop = $j('img#image-main');
                    $crop.cropper('destroy');
                    var w_ = $j('#room_width').val();
                    var h_ = $j('#room_length').val();
                    $j('.f-width').text( w_ / 100 + 'm');
                    $j('.f-height').text( h_ / 100 + 'm');
                    ca.calcRoom();

                    $crop.cropper({
                      aspectRatio: w_ / h_,
                      autoCropArea:1,
                      zoomable:false,
                      cropBoxResizable:false,
                      toggleDragModeOnDblclick:false,
                      dragMode:'none',
                      crop: function(e) {
                        var crop    = {};
                        crop.x           = e.x;
                        crop.y           = e.y;
                        crop.width       = e.width;
                        crop.height       = e.height;
                        crop.scaleX       = e.scaleX;
                        crop.scaleY       = e.scaleY;     
                        crop.grayscale    = $j('span.cropper-view-box').hasClass('grayscale') ? 1 : 0;
                        $j('input.crop_image').val( JSON.stringify(crop) ); 

                      }
                    });
        }
    });





});









});      

jQuery(function($j){

    if( $j('.product-shop').hasClass('is_carpet') ) {

      if( $j('ul.cerceve input[type="radio"]:checked').length < 1 ) {

        $j('button.btn-cart').attr('disabled',true).addClass('disabled');
        $j('.add-to-cart').click(function(){
            if( $j('ul.cerceve input[type="radio"]:checked').length < 1 ) {
              var lang = $j('html').attr('lang');
              if( lang === 'tr' ){
                alert('Lütfen malzeme seçimi yapınız.');  
              } else { 
                alert('Please Select Material !');
              }
            }
        });        

      }


    } else {

    }    

    $j('ul.cerceve').click(function(){
      if( $j('input[name="room_width"], input[name="room_length"]').val() < 20 ) {
        alert( 'Lütfen genişlik ve yüksekliği 20cm den yüksek bir değer giriniz.');
        $j('input[name="room_width"]').focus();
      } else {
      $j('button.btn-cart').attr('disabled',false).removeClass('disabled');
      }
    });

});



eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('1k(l($j){$j(\'.1j\').1i(l(e){e.1h();g A=$j(\'.1l\').C();g B=$j(\'.1m\').C();g f=$j(\'.1q\').1p(\'f\');g h=D(f,B,A);$j(\'.Y .Z\').1e(h);y.z(h);y.z(\'1g\')})});l D(f,N,a){g c=0;g h=0;b(f===\'1b\'){b((a>E)&&(a<=k)){c=1}d b((a<=E)&&(a>J)){c=2}d b((a<=J)&&(a>I)){c=3}d b((a<=I)&&(a>x)){c=4}d b((a<=x)&&(a>F)){c=6}d b((a<=F)&&(a>i)){c=9}d b((a<=i)&&(a>0)){c=18}}d b(f===\'1a\'){b((a>G)&&(a<=k)){c=1}d b((a<=G)&&(a>K)){c=2}d b((a<=K)&&(a>q)){c=3}d b((a<=q)&&(a>m)){c=4}d b((a<=m)&&(a>n)){c=5}d b((a<=n)&&(a>o)){c=7}d b((a<=o)&&(a>0)){c=15}}d b(f===\'1s\'){b((a>p)&&(a<=k)){c=1}d b((a<=p)&&(a>w)){c=2}d b((a<=w)&&(a>u)){c=3}d b((a<=u)&&(a>L)){c=4}d b((a<=L)&&(a>t)){c=5}d b((a<=t)&&(a>r)){c=6}d b((a<=r)&&(a>s)){c=7}d b((a<=s)&&(a>v)){c=8}d b((a<=v)&&(a>H)){c=9}d b((a<=H)&&(a>V)){c=10}d b((a<=V)&&(a>S)){c=11}d b((a<=S)&&(a>P)){c=12}d b((a<=P)&&(a>R)){c=13}d b((a<=R)&&(a>M)){c=14}d b((a<=M)&&(a>U)){c=15}d b((a<=U)&&(a>Q)){c=16}d b((a<=Q)&&(a>O)){c=17}d b((a<=O)&&(a>T)){c=18}d b((a<=T)&&(a>W)){c=19}d b((a<=W)&&(a>X)){c=1c}d b((a<=X)&&(a>0)){c=1o}}h=1d(N/(c*i));1f 1n.1r(h)}',62,91,'||||||||||yukseklik|if|donenrakam|else||formul|var|hesaplanan|53||1005|function|192|128|64|502|220|143|125|167|251|111|335|159|console|log|height|width|val|formulHesapla|477|106|448|100|212|318|320|201|67|genislik|55|77|59|71|83|52|62|91|50|47|c_total|number|||||||||||formul64|formul53|20|parseFloat|html|return|hesaplama|preventDefault|click|a_calcer|jQuery|d_height|d_width|Math|21|data|d_calculator|ceil|formul0'.split('|'),0,{}))