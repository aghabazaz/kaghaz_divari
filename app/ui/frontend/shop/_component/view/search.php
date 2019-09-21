<?php //\f\pr($param);?>
<form id="quick-search-header" class="quick-search-header" id="" action="<?= \f\ifm::app ()->siteUrl ?>search" method="post">
    <fieldset>
        <div class="col-sm-2">
            <legend style="width:auto !important;border:0">جستجوی دستگاه : </legend>
        </div>

        <div class="col-sm-10" style="padding-top:10px">
            <div class="col-sm-3"  >
                <div class="" >
                    <label for="category">نوع دستگاه</label>
                    <select name="category" >
                        <option></option>
                        <?php
                        foreach ( $category AS $data )
                        {
                            echo '<option value="' . $data[ 'id' ] . '">' . $data[ 'title' ] . '</option>' ;
                        }
                        ?>

                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="" >
                    <label for="title">نام دستگاه </label>
                    <input type="text" name="title" value="<?= $param['title']?>">
                </div>

            </div>
            <div class="col-sm-3"  >
                <div class="" >
                    <label for="country">کشور سازنده</label>
                    <select name="country">
                        <option></option>
                        <?php
                        foreach ( $country AS $data )
                        {
                            echo '<option value="' . $data[ 'id' ] . '">' . $data[ 'countryNameFa' ] . '</option>' ;
                        }
                        ?>

                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="" >
                    <label for="axis_speed_x">کورس محور X</label>
                    <input type="text" name="axis_speed_x" >
                </div>

            </div>
            <div class="col-sm-3"  >
                <div class="" >
                    <label for="price_min">حداقل قیمت (تومان)</label>
                    <input type="text" name="price_min" >
                </div>
            </div>
            <div class="col-sm-3">
                <div class="" >
                    <label for="control">عنوان کنترل</label>
                    <select name="control">
                        <option></option>
                        <?php
                        foreach ( $baseInfo[ 'control' ][ 'title' ] AS $key => $val )
                        {
                            echo '<option value="' . $key . '">' . $val . '</option>' ;
                        }
                        ?>

                    </select>
                </div>

            </div>
            <div class="col-sm-3"  >
                <div class="" >
                    <label for="year">سال ساخت</label>
                    <select name="year">
                        <option></option>
                        <?php
                        $year = date ( 'Y' ) ;
                        for ( $i = $year ; $i > $year - 50 ; $i-=5 )
                        {
                            echo '<option value="' . $i . '-' . ($i - 5) . '">' . ($i - 5) . ' تا ' . ($i) . '</option>' ;
                        }
                        ?>

                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="" >
                    <label for="axis_speed_y">کورس محور Y</label>
                    <input type="text" name="axis_speed_y" >
                </div>

            </div>
            <div class="col-sm-3"  >
                <div class="" >
                    <label for="price_max">حداکثر قیمت (تومان)</label>
                    <input type="text" name="price_max" >
                </div>
            </div>
            <div class="col-sm-3">
                <div class="" >
                    <label for="num_axis">تعداد محور</label>
                    <select name="num_axis">
                        <option></option>
                        <?php
                        foreach ( $baseInfo[ 'axis' ][ 'title' ] AS $key => $val )
                        {
                            echo '<option value="' . $key . '">' . $val . '</option>' ;
                        }
                        ?>

                    </select>
                </div>

            </div>
            <div class="col-sm-3"  >
                <div class="" >
                    <label for="statusProduct">وضعیت دستگاه</label>
                    <select name="statusProduct">
                        <option></option>
                        <?php
                        foreach ( $baseInfo[ 'condition' ][ 'title' ] AS $key => $val )
                        {
                            echo '<option value="' . $key . '">' . $val . '</option>' ;
                        }
                        ?>

                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="" >
                    <label for="axis_speed_z">کورس محور Z</label>
                    <input type="text" name="axis_speed_z" >
                </div>

            </div>

            <div class="col-sm-3">
                <button type="submit">جستجو</button>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>






    </fieldset>	
    <div class="grid-row" style="margin: 0px auto;position: relative">
        <div class="switcher">
            <button id="quick-search-header-switcher" type="button">جستجوی پیشرفته</button>
        </div>
    </div>

</form>
<script>
    widgetHelper.makeSelect2('select', 'انتخاب کنید...');
</script>