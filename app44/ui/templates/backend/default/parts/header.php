<div class="top-bar">
    <div class="container">
        <div class="row">
            <!-- logo -->
            <div class="col-md-2 " style="height: 30px;">
                <!--<a href="<?= \f\ifm::app()->legacyBaseUrl ?>cms/content/manage">
                    <img src="<?= \f\ifm::app()->fileBaseUrl ?>361" alt="Admin Dashboard">                        
                </a>
				-->
            </div>

            <div class="col-md-10" >
                <div class="row">
                    <div class="col-md-3">
                        <!-- search box -->
                        <div id="tour-searchbox" class="input-group searchbox">
                            <input type="search" class="form-control" placeholder="جستجو">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                        <!-- end search box -->
                    </div>
                    <div class="col-md-9">
                        <div class="top-bar-right">
                            <div class="logged-user">
                                <div class="btn-group">
                                    <a href="index.html#" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                                        <?php
                                        $userInfo      = \f\ttt::service('core.auth.getEnteredUserInfo') ;
										//\f\pr($userInfo);
                                        $userProfileId = $userInfo[ 'profile_pic' ] ;
                                        ?>
                                        <!--<img style="width: 26px; height: 26px" src="<?= \f\ifm::app()->fileBaseUrl . $userProfileId ?>" />-->
                                        <span class="name">&nbsp;<?= $userInfo[ 'username' ] ?>&nbsp;</span> <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="<?= \f\ifm::app()->baseUrl ?>core/auth/logout">
                                                <i class="fa fa-power-off"></i>
                                                <span class="text">خروج</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- end logo -->
                    </div><!-- /row -->
                </div>
            </div><!-- /container -->
        </div><!-- /top -->
    </div>
</div>