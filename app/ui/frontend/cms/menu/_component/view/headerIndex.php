<div class="header-column justify-content-end">
    <div class="header-nav">
        <div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1">
            <nav class="collapse">
                <ul class="nav flex-column flex-lg-row" id="mainNav">

                    <?php

                    foreach ( $row AS $data )
                    {
                       // \f\pre(\f\ifm::app ()->siteUrl.'/file/'.$data['picture']);
                        if ( $data[ 'data' ][ 'link' ] )
                        {
                            $link = $data[ 'data' ][ 'link' ] . '/' ;
                        }
                        else
                        {
                            if($data['data']['type']=='page')
                            {

                                $link = \f\ifm::app ()->siteUrl . 'page/' . $data[ 'data' ][ 'page' ] ;
                            }
                            else
                            {

                                $link = \f\ifm::app ()->siteUrl . 'menuDetail/' . $data[ 'data' ][ 'id' ] ;

                            }
                        }
                        $arr  = explode ( "/", $actual_link ) ;

                        $arr2 = explode ( "/", $link ) ;

                        if ( ($arr[ '3' ] == $arr2[ '3' ] ) )
                        {
                            $class = "class='active'" ;
                        }
                        else
                        {
                            $class = '' ;
                        }

                        if(count($data['child'])>0){?>
                            <li class="dropdown dropdown-mega dropdown-mega-style-2">
                                <a class="dropdown-item dropdown-toggle" href="#">
                                   <?=$data[ 'data' ][ 'title' ]?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <div class="dropdown-mega-content container" style="background-image: url('<?= \f\ifm::app ()->siteUrl.'file/'.$data[ 'data' ]['picture']?>')">
                                            <div class="row">
                                                <?php
                                                foreach ($data[ 'child' ] AS $val2 ){
                                                    if ( $val2[ 'data' ][ 'link' ] )
                                                    {
                                                        $link = $val2[ 'data' ][ 'link' ] . '/' ;
                                                    }
                                                    else
                                                    {
                                                        if($val2['data']['type']=='page')
                                                        {

                                                            $link2 = \f\ifm::app ()->siteUrl . 'page/' . $val2[ 'data' ][ 'page' ] ;
                                                        }
                                                        else
                                                        {

                                                            $link2 = \f\ifm::app ()->siteUrl . 'menuDetail/' . $val2[ 'data' ][ 'id' ] ;

                                                        }
                                                    }
                                                    if(count($val2['child'])>0){
                                                ?>
                                                <div class="col-lg-2">
                                                    <span
                                                        class="dropdown-mega-sub-title"><?= $val2['data']['title'] ?></span>
                                                    <ul class="dropdown-mega-sub-nav">
                                                        <?php
                                                        foreach ($val2['child'] as $val3) {
                                                            if ($val3['data']['link']) {
                                                                $link = $val3['data']['link'] . '/';
                                                            } else {
                                                                if ($val3['data']['type'] == 'page') {

                                                                    $link3 = \f\ifm::app()->siteUrl . 'page/' . $val3['data']['page'];
                                                                } else {

                                                                    $link3 = \f\ifm::app()->siteUrl . 'menuDetail/' . $val3['data']['id'];

                                                                }
                                                            }
                                                            ?>
                                                            <li>
                                                                <a class="dropdown-item"
                                                                   href="<?= $link3 ?>"> <?= $val3['data']['title'] ?> </a>
                                                            </li>
                                                            <?php
                                                        }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <div class="col-lg-3">
                                                            <a href="<?=$link2?>" class="dropdown-mega-sub-title"><?=$val2['data']['title']?></a>
                                                        </div>
                                                   <?php
                                                    }
                                                    ?>

                            <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                          <?php
                        }else{
                            ?>
                            <li>
                                <a class="dropdown-item" href="<?=$link?>">
                                    <?=$data[ 'data' ][ 'title' ]?>
                                </a>

                       <?php
                        }?>
                    </li>
                        <?php
                    }
                    ?>
                </ul>
            </nav>
        </div>
        <button class="header-btn-collapse-nav header-btn-collapse-nav-light ml-3" data-toggle="collapse" data-target=".header-nav-main nav">
										<span class="hamburguer">
											<span></span>
											<span></span>
											<span></span>
										</span>
            <span class="close">
											<span></span>
											<span></span>
										</span>
        </button>
    </div>
</div>
