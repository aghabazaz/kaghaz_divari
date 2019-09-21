<?php

namespace f\g ;

class upload
{

    //-------------------------------------------------------------------------------------
    public function upload($uploadpath, $inputName, $maxSize, $allowed_filetypes = '', $resize = 0, $maxW = 600, $maxH = 400, $maxW_thumb = 200, $maxH_thumb = 140) {

        if (!isset($_FILES[$inputName]))
            return array(
                'failed', 'file name not exists !'
            );

        $filename = $_FILES[$inputName]['name'];
        if ($filename) {
            $file_size = @filesize($_FILES[$inputName]['tmp_name']);

            if ($file_size <= $maxSize * 1024) {

                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                if (in_array($ext, $allowed_filetypes) || !$allowed_filetypes) {
                    if (is_writable($uploadpath)) {
                        $upload = move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadpath . $filename);
                        if ($upload) {
                            $newFileName = '_' . $inputName . '_' . time() . '.' . $ext;
                            if (rename($uploadpath . $filename, $uploadpath . $newFileName)) {
                                if ($resize == 1) {
                                    if ($maxW == 0) {
                                        $maxW = 600;
                                    }
                                    if ($maxH == 0) {
                                        $maxH = 400;
                                    }
                                    if ($maxW_thumb == 0) {
                                        $maxW_thumb = 200;
                                    }
                                    if ($maxH_thumb == 0) {
                                        $maxH_thumb = 140;
                                    }
                                    $resizeobj = new resize($uploadpath . $newFileName);
                                    $resizeobj->resizeImage($maxW, $maxH, 'auto');
                                    $resizeobj->saveImage($uploadpath . '_main' . $newFileName, 100);
                                    $resizeobj->resizeImage($maxW_thumb, $maxH_thumb, 'exact');
                                    $resizeobj->saveImage($uploadpath . '_thumb' . $newFileName, 100);
                                }
                                $data = array('success', $newFileName, $ext);
                            } else {
                                $data = array('error', 'rename');
                            }
                        } else {

                            $data = array('error', 'upload');
                        }
                    } else {
                        $data = array('error', 'path');
                    }
                } else {
                    $data = array('error', 'extension');
                }
            } else {
                $data = array('error', 'filesize');
            }
        } else {
            $data = array('success', '');
        }
        return $data;
    }
//-------------------------------------------------------------------------------------
    function uploadArray($uploadpath, &$file_post, $maxSize, $allowed_filetypes = '', $resize = 0, $maxW = 600, $maxH = 400, $maxW_thumb = 200, $maxH_thumb = 140) {

        
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }
        
    $data = array();
    
    if (!isset($file_ary))
            return array(
                'failed', 'file name not exists !'
            );
    
     foreach($file_ary as $file){
      
         

        $filename = $file['name'];
        if ($filename) {
            $file_size = @filesize($file['tmp_name']);

            if ($file_size <= $maxSize * 1024) {

                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                if (in_array($ext, $allowed_filetypes) || !$allowed_filetypes) {
                    if (is_writable($uploadpath)) {
                        $upload = move_uploaded_file($file['tmp_name'], $uploadpath . $filename);
                        if ($upload) {
                            
                            $random = rand(000, 999);
                            
                            $newFileName = '_' . $random . '_' . time() . '.' . $ext;
                            if (rename($uploadpath . $filename, $uploadpath . $newFileName)) {
                                if ($resize == 1) {
                                    if ($maxW == 0) {
                                        $maxW = 600;
                                    }
                                    if ($maxH == 0) {
                                        $maxH = 400;
                                    }
                                    if ($maxW_thumb == 0) {
                                        $maxW_thumb = 200;
                                    }
                                    if ($maxH_thumb == 0) {
                                        $maxH_thumb = 140;
                                    }
                                    $resizeobj = new resize($uploadpath . $newFileName);
                                    $resizeobj->resizeImage($maxW, $maxH, 'auto');
                                    $resizeobj->saveImage($uploadpath . '_main' . $newFileName, 100);
                                    $resizeobj->resizeImage($maxW_thumb, $maxH_thumb, 'exact');
                                    $resizeobj->saveImage($uploadpath . '_thumb' . $newFileName, 100);
                                }
                                $data[] = array('success', $newFileName, $ext);
                            } else {
                                $data[] = array('error', 'rename');
                            }
                        } else {

                            $data[] = array('error', 'upload');
                        }
                    } else {
                        $data[] = array('error', 'path');
                    }
                } else {
                    $data[] = array('error', 'extension');
                }
            } else {
                $data[] = array('error', 'filesize');
            }
        } else {
            $data[] = array('success', '');
        }
         
     }
        return $data;
    }
    //-----------------------------------------------------------------------------
    function resize_pic($count, $uploadpath, $fileName, $maxW = 600, $maxH = 400, $maxW_thumb = 200, $maxH_thumb = 140) {
        if ($maxW == 0) {
            $maxW = 600;
        }
        if ($maxH == 0) {
            $maxH = 400;
        }
        if ($maxW_thumb == 0) {
            $maxW_thumb = 200;
        }
        if ($maxH_thumb == 0) {
            $maxH_thumb = 140;
        }
        $newFileName = '_' . $count . $fileName;
        $resizeobj = new resize($uploadpath . $fileName);
        $resizeobj->resizeImage($maxW, $maxH, 'auto');
        $resizeobj->saveImage($uploadpath . '_main' . $newFileName, 100);
        $resizeobj->resizeImage($maxW_thumb, $maxH_thumb, 'auto');
        $resizeobj->saveImage($uploadpath . '_thumb' . $newFileName, 100);

        return array('success', $newFileName);
    }

}
