<?php

namespace f\g ;

class email
{

    function mailAttachments ( $to, $from, $subject, $message,
                               $attachments = array ( ) ,
                               $headers = array ( ) ,
                               $additional_parameters = '' )
    {
        /////how to use : mailAttachments($to, $from, $from, $txt, array('img.png'=>'img.png'), $headers = array(), $additional_parameters = '');
        // Define the boundray we're going to use to separate our data with.
        $mime_boundary = '==MIME_BOUNDARY_' . md5 ( time () ) ;

        // Define attachment-specific headers
        $headers[ 'MIME-Version' ] = '1.0' ;
        $headers[ 'Content-Type' ] = 'multipart/mixed; boundary="' . $mime_boundary . '"' ;
        $headers[ 'From' ]         = $from ;
        // Convert the array of header data into a single string.
        $headers_string          = '' ;
        foreach ( $headers as $header_name => $header_value )
        {
            if ( ! empty ( $headers_string ) )
            {
                $headers_string .= "\r\n" ;
            }
            $headers_string .= $header_name . ': ' . $header_value ;
        }

        // Message Body
        $message_string = '--' . $mime_boundary ;
        $message_string .= "\r\n" ;
        $message_string .= 'Content-type:text/html;charset=utf-8"' ;
        $message_string .= "\r\n" ;
        $message_string .= 'Content-Transfer-Encoding: 7bit' ;
        $message_string .= "\r\n" ;
        $message_string .= "\r\n" ;
        $message_string .= $message ;
        $message_string .= "\r\n" ;
        $message_string .= "\r\n" ;

        // Add attachments to message body
        foreach ( $attachments as $local_filename => $attachment_filename )
        {
            if ( is_file ( $local_filename ) )
            {

                $message_string .= '--' . $mime_boundary ;
                $message_string .= "\r\n" ;
                $message_string .= 'Content-Type: application/octet-stream; name="' . $attachment_filename . '"' ;
                $message_string .= "\r\n" ;
                $message_string .= 'Content-Description: ' . $attachment_filename ;
                $message_string .= "\r\n" ;

                $fp        = @fopen ( $local_filename, 'rb' ) ; // Create pointer to file
                $file_size = filesize ( $local_filename ) ; // Read size of file
                $data      = @fread ( $fp, $file_size ) ; // Read file contents
                $data      = chunk_split ( base64_encode ( $data ) ) ; // Encode file contents for plain text sending

                $message_string .= 'Content-Disposition: attachment; filename="' . $attachment_filename . '"; size=' . $file_size . ';' ;
                $message_string .= "\r\n" ;
                $message_string .= 'Content-Transfer-Encoding: base64' ;
                $message_string .= "\r\n\r\n" ;
                $message_string .= $data ;
                $message_string .= "\r\n\r\n" ;
            }
        }

        // Signal end of message
        $message_string .= '--' . $mime_boundary . '--' ;

        // Send the e-mail.
        return mail ( $to, $subject, $message_string, $headers_string,
                      $additional_parameters ) ;
    }

    function send ( $email, $from, $message, $subject )
    {
///////////////////////////////////////////e
///////////////////////////////////////////m
///////////////////////////////////////////a
///////////////////////////////////////////i
///////////////////////////////////////////l
// To send the HTML mail we need to set the Content-type header.
        $headers = "MIME-Version: 1.0" . "\r\n" ;
        $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n" ;
        $headers .= 'From: ' . $from . "\r\n" ;
        $headers .= 'Reply-To: ' . $from . "\r\n" ;
        $headers .= 'X-Mailer: PHP/' . phpversion () ;
//options to send to cc+bcc
//$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";
//$headers .= "Bcc: [email]email@maaking.cXom[/email]";
// now lets send the email.
        $result  = mail ( $email, $subject, $message, $headers ) ;

        return $result ;
    }

}

