<link rel="stylesheet" href="/public/assets/css/scroll/style.css">

<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->

<!-- custom scrollbar stylesheet -->
<link rel="stylesheet" href="/public/assets/css/scroll/jquery.mCustomScrollbar.css">
<link rel="stylesheet" href="https://cdn.anychart.com/css/latest/anychart-ui.min.css"/>
<style>
    @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300,800);

    #container_chart {
        width: 100%;
        height: 800px;
        margin: 0;
        padding: 0;
    }

    #drag_box1 > div > span > img, #drag_box2 > div > span > img {
        width: 146px;
        height: 130px;
        border-radius: 1em;
        cursor:pointer;
    }

    #drag_box2 > div {
        float: left;
        display: inline;
    }
    #drag_box1 > div, #drag_box2 > div {
        padding: 8px;
        font-size: 16px;
        text-align: center;
    }
    input::-webkit-input-placeholder{
        font-family: 'roboto', sans-serif;
        transition: all 0.3s ease-in-out;
    }

    input {
        width: 200px;
        border: none;
        border-bottom: solid 1px #1abc9c;
        -webkit-transition: all 0.3s cubic-bezier(0.64, 0.09, 0.08, 1);
        transition: all 0.3s cubic-bezier(0.64, 0.09, 0.08, 1);
        background: -webkit-linear-gradient(top, rgba(255, 255, 255, 0) 96%, #1abc9c 4%);
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 96%, #1abc9c 4%);
        background-position: -200px 0;
        background-size: 200px 100%;
        background-repeat: no-repeat;
        color: #0e6252;
    }
    input:focus, input:valid {
        box-shadow: none;
        outline: none;
        background-position: 0 0;
    }
    input:focus::-webkit-input-placeholder, input:valid::-webkit-input-placeholder {
        color: #1abc9c;
        font-size: 11px;
        -webkit-transform: translateY(-20px);
        transform: translateY(-20px);
        visibility: visible !important;
    }
    input[type=date]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        display: none;
    }
</style>

<style type="text/css">
    ${demo.css}
</style>
<script type="text/javascript">
    $(function () {
        var categories = [
                <?php
                $cnt = count($farm0);
                for($i = 0; $i < $cnt; $i++) {
                    if($i == $cnt-1) {
                        echo "'".$farm0[$i]->fname."'";
                    } else {
                        echo "'".$farm0[$i]->fname."', ";
                    }
                } ?>
            ],
            data = [
                <?php
                $cnt = 0;
                foreach($farms_mstock0 as $row) { ?>
                {
                 y: <?php
                    $mstock = $row->smt;
                    $smt = $total_mstock0->smt;
                    $result = $mstock * 100 / floatval($smt);
                    echo sprintf('%.2f', $result) ?>,
                    color: "<?= $row->fcolor ?>",
                    drilldown: {
                        name: <?php echo "'".$row->fname."'"; ?>,
                        categories: [
                            <?php foreach($farms_crops0 as $row2) {
                                if($row->fno == $row2->fno) {
                                    echo "'".$row2->cname."',";
                                }
                            }?>],
                        danger: [<?php foreach($farms_crops0 as $row2) {
                            if($row->fno == $row2->fno) {
                                echo "'".$row2->danger."',";
                            }
                        }?>],
                        data: [<?php
                            foreach($farms_crops0 as $row3) {
                                if($row->fno == $row3->fno) {
                                    echo $row3->mstock.", ";
                                }
                            }
                            ?>
                            ],
                        color: "<?= $row->fcolor ?>"
                    }
                },
                <?php $cnt++; } ?>
            ],
            browserData = [],
            versionsData = [],
            i,
            j,
            dataLen = data.length,
            drillDataLen,
            brightness;

        // Build the data arrays
        for (i = 0; i < dataLen; i += 1) {

            // add browser data
            browserData.push({
                name: categories[i],
                y: data[i].y,
                color: data[i].color
            });

            // add version data
            drillDataLen = data[i].drilldown.data.length;
            for (j = 0; j < drillDataLen; j += 1) {
                brightness = 0.2 - (j / drillDataLen) / 5;
                versionsData.push({
                    name: data[i].drilldown.categories[j],
                    y: data[i].drilldown.data[j],
                    z: data[i].drilldown.danger[j],
                    color: data[i].drilldown.data[j] <= data[i].drilldown.danger[j] ? "rgb(255,72,72)" : Highcharts.Color(data[i].color).brighten(brightness).get()
                });
            }
        }
        // Create the chart
        $('#container0').highcharts({
            chart: {
                type: 'pie'
            },
            title: {
                text: '産地ごとの食材の残量',
                style: {
                    fontSize: "18pt",
                    fontWeight: 'bold',
                    margin: '100px'
                }
            },
            tooltip: {
                style: {
                    fontWeight: 'bold'
                }
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    center: ['50%', '50%']
                }
            },
            series: [{
                name: "占有率(%)",
                data: browserData,
                size: '50%',
                dataLabels: {
                    style: {
                        fontSize: "12pt"
                    },
                    formatter: function () {
                        return this.y > 5 ? this.point.name : null;
                    },
                    color: '#ffffff',
                    distance: -30
                }
            }, {
                name: "残量(kg)",
                data: versionsData,
                size: '80%',
                innerSize: '60%',
                z: versionsData.danger,
                dataLabels: {
                    style: {
                        fontSize: "16pt",
                        color: "#FF3636",
                        fontWeight: 'bold'
                    },
                    formatter: function () {
                        // display only if larger than 1
                        return this.y <= this.point.options.z ? "<b>\u26a0 " +  this.point.name + ':</b> ' + this.y + "kg" : null;
                    }
                }
            }]
        });
    });
    $(function () {
        var categories = [
                <?php
                $cnt = count($farm1);
                for($i = 0; $i < $cnt; $i++) {
                    if($i == $cnt-1) {
                        echo "'".$farm1[$i]->fname."'";
                    } else {
                        echo "'".$farm1[$i]->fname."', ";
                    }
                } ?>
            ],
            data = [
                <?php
                $cnt = 0;
                foreach($farms_mstock1 as $row) { ?>
                {
                    y: <?php
                    $mstock = $row->smt;
                    $smt = $total_mstock1->smt;
                    $result = $mstock * 100 / floatval($smt);
                    echo sprintf('%.2f', $result) ?>,
                    color: "<?= $row->fcolor ?>",
                    drilldown: {
                        name: <?php echo "'".$row->fname."'"; ?>,
                        categories: [
                            <?php foreach($farms_crops1 as $row2) {
                            if($row->fno == $row2->fno) {
                                echo "'".$row2->cname."',";
                            }
                        }?>],
                        danger: [<?php foreach($farms_crops1 as $row2) {
                            if($row->fno == $row2->fno) {
                                echo "'".$row2->danger."',";
                            }
                        }?>],
                        data: [<?php
                            foreach($farms_crops1 as $row3) {
                                if($row->fno == $row3->fno) {
                                    echo $row3->mstock.", ";
                                }
                            }
                            ?>
                        ],
                        color: "<?= $row->fcolor ?>"
                    }
                },
                <?php $cnt++; } ?>
            ],
            browserData = [],
            versionsData = [],
            i,
            j,
            dataLen = data.length,
            drillDataLen,
            brightness;

        // Build the data arrays
        for (i = 0; i < dataLen; i += 1) {

            // add browser data
            browserData.push({
                name: categories[i],
                y: data[i].y,
                color: data[i].color
            });

            // add version data
            drillDataLen = data[i].drilldown.data.length;
            for (j = 0; j < drillDataLen; j += 1) {
                brightness = 0.2 - (j / drillDataLen) / 5;
                versionsData.push({
                    name: data[i].drilldown.categories[j],
                    y: data[i].drilldown.data[j],
                    z: data[i].drilldown.danger[j],
                    color: data[i].drilldown.data[j] <= data[i].drilldown.danger[j] ? "rgb(255,72,72)" : Highcharts.Color(data[i].color).brighten(brightness).get()
                });
            }
        }
        // Create the chart
        $('#container1').highcharts({
            chart: {
                type: 'pie'
            },
            title: {
                text: '産地ごとの食材の残量',
                style: {
                    fontSize: "18pt",
                    fontWeight: 'bold',
                    margin: '100px'
                }
            },
            tooltip: {
                style: {
                    fontWeight: 'bold'
                }
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    center: ['50%', '50%']
                }
            },
            series: [{
                name: "占有率(%)",
                data: browserData,
                size: '50%',
                dataLabels: {
                    style: {
                        fontSize: "12pt"
                    },
                    formatter: function () {
                        return this.y > 5 ? this.point.name : null;
                    },
                    color: '#ffffff',
                    distance: -30
                }
            }, {
                name: "残量(kg)",
                data: versionsData,
                size: '80%',
                innerSize: '60%',
                dataLabels: {
                    style: {
                        fontSize: "16pt",
                        color: "#FF3636",
                        fontWeight: 'bold'
                    },
                    formatter: function () {
                        // display only if larger than 1
                        return this.y <= this.point.options.z ?  "<b>\u26a0 " +  this.point.name + ':</b> ' + this.y + "kg" : null;
                    }
                }
            }]
        });
    });
    $(function () {
        var categories = [
                <?php
                $cnt = count($farm2);
                for($i = 0; $i < $cnt; $i++) {
                    if($i == $cnt-1) {
                        echo "'".$farm2[$i]->fname."'";
                    } else {
                        echo "'".$farm2[$i]->fname."', ";
                    }
                } ?>
            ],
            data = [
                <?php
                $cnt = 0;
                foreach($farms_mstock2 as $row) { ?>
                {
                    y: <?php
                    $mstock = $row->smt;
                    $smt = $total_mstock2->smt;
                    $result = $mstock * 100 / floatval($smt);
                    echo sprintf('%.2f', $result) ?>,
                    color: "<?= $row->fcolor ?>",
                    drilldown: {
                        name: <?php echo "'".$row->fname."'"; ?>,
                        categories: [
                            <?php foreach($farms_crops2 as $row2) {
                            if($row->fno == $row2->fno) {
                                echo "'".$row2->cname."',";
                            }
                        }?>],
                        danger: [<?php foreach($farms_crops2 as $row2) {
                            if($row->fno == $row2->fno) {
                                echo "'".$row2->danger."',";
                            }
                        }?>],
                        data: [<?php
                            foreach($farms_crops2 as $row3) {
                                if($row->fno == $row3->fno) {
                                    echo $row3->mstock.", ";
                                }
                            }
                            ?>
                        ],
                        color: "<?= $row->fcolor ?>"
                    }
                },
                <?php $cnt++; } ?>
            ],
            browserData = [],
            versionsData = [],
            i,
            j,
            dataLen = data.length,
            drillDataLen,
            brightness;

        // Build the data arrays
        for (i = 0; i < dataLen; i += 1) {

            // add browser data
            browserData.push({
                name: categories[i],
                y: data[i].y,
                color: data[i].color
            });

            // add version data
            drillDataLen = data[i].drilldown.data.length;
            for (j = 0; j < drillDataLen; j += 1) {
                brightness = 0.2 - (j / drillDataLen) / 5;
                versionsData.push({
                    name: data[i].drilldown.categories[j],
                    y: data[i].drilldown.data[j],
                    z: data[i].drilldown.danger[j],
                    color: data[i].drilldown.data[j] <= data[i].drilldown.danger[j] ? "rgb(255,72,72)" : Highcharts.Color(data[i].color).brighten(brightness).get()
                });
            }
        }
        // Create the chart
        $('#container2').highcharts({
            chart: {
                type: 'pie'
            },
            title: {
                text: '産地ごとの食材の残量',
                style: {
                    fontSize: "18pt",
                    fontWeight: 'bold',
                    margin: '100px'
                }
            },
            tooltip: {
                style: {
                    fontWeight: 'bold'
                }
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    center: ['50%', '50%']
                }
            },
            series: [{
                name: "占有率(%)",
                data: browserData,
                size: '50%',
                dataLabels: {
                    style: {
                        fontSize: "12pt"
                    },
                    formatter: function () {
                        return this.y > 5 ? this.point.name : null;
                    },
                    color: '#ffffff',
                    distance: -30
                }
            }, {
                name: "残量(kg)",
                data: versionsData,
                size: '80%',
                innerSize: '60%',
                dataLabels: {
                    style: {
                        fontSize: "16pt",
                        color: "#FF3636",
                        fontWeight: 'bold'
                    },
                    formatter: function () {
                        // display only if larger than 1
                        return this.y <= this.point.options.z ?  "<b>\u26a0 " +  this.point.name + ':</b> ' + this.y + "kg" : null;
                    }
                }
            }]
        });
    });
    $(function () {
        var categories = [
                <?php
                $cnt = count($farm3);
                for($i = 0; $i < $cnt; $i++) {
                    if($i == $cnt-1) {
                        echo "'".$farm3[$i]->fname."'";
                    } else {
                        echo "'".$farm3[$i]->fname."', ";
                    }
                } ?>
            ],
            data = [
                <?php
                $cnt = 0;
                foreach($farms_mstock3 as $row) { ?>
                {
                    y: <?php
                    $mstock = $row->smt;
                    $smt = $total_mstock3->smt;
                    $result = $mstock * 100 / floatval($smt);
                    echo sprintf('%.2f', $result) ?>,
                    color: "<?= $row->fcolor ?>",
                    drilldown: {
                        name: <?php echo "'".$row->fname."'"; ?>,
                        categories: [
                            <?php foreach($farms_crops3 as $row2) {
                            if($row->fno == $row2->fno) {
                                echo "'".$row2->cname."',";
                            }
                        }?>],
                        danger: [<?php foreach($farms_crops3 as $row2) {
                            if($row->fno == $row2->fno) {
                                echo "'".$row2->danger."',";
                            }
                        }?>],
                        data: [<?php
                            foreach($farms_crops3 as $row3) {
                                if($row->fno == $row3->fno) {
                                    echo $row3->mstock.", ";
                                }
                            }
                            ?>
                        ],
                        color: "<?= $row->fcolor ?>"
                    }
                },
                <?php $cnt++; } ?>
            ],
            browserData = [],
            versionsData = [],
            i,
            j,
            dataLen = data.length,
            drillDataLen,
            brightness;

        // Build the data arrays
        for (i = 0; i < dataLen; i += 1) {

            // add browser data
            browserData.push({
                name: categories[i],
                y: data[i].y,
                color: data[i].color
            });

            // add version data
            drillDataLen = data[i].drilldown.data.length;
            for (j = 0; j < drillDataLen; j += 1) {
                brightness = 0.2 - (j / drillDataLen) / 5;
                versionsData.push({
                    name: data[i].drilldown.categories[j],
                    y: data[i].drilldown.data[j],
                    z: data[i].drilldown.danger[j],
                    color: data[i].drilldown.data[j] <= data[i].drilldown.danger[j] ? "rgb(255,72,72)" : Highcharts.Color(data[i].color).brighten(brightness).get()
                });
            }
        }
        // Create the chart
        $('#container3').highcharts({
            chart: {
                type: 'pie'
            },
            title: {
                text: '肉類の在庫',
                style: {
                    fontSize: "18pt",
                    fontWeight: 'bold',
                    margin: '100px'
                }
            },
            tooltip: {
                style: {
                    fontWeight: 'bold'
                }
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    center: ['50%', '50%']
                }
            },
            series: [{
                name: "占有率(%)",
                data: browserData,
                size: '50%',
                dataLabels: {
                    style: {
                        fontSize: "12pt"
                    },
                    formatter: function () {
                        return this.y > 5 ? this.point.name : null;
                    },
                    color: '#ffffff',
                    distance: -30
                }
            }, {
                name: "残量(kg)",
                data: versionsData,
                size: '80%',
                innerSize: '60%',
                dataLabels: {
                    style: {
                        fontSize: "16pt",
                        color: "#FF3636",
                        fontWeight: 'bold'
                    },
                    formatter: function () {
                        // display only if larger than 1
                        return this.y <= this.point.options.z ?  "<b>\u26a0 " +  this.point.name + ':</b> ' + this.y + "kg" : null;
                    }
                }
            }]
        });
    });
</script>

<script src="/public/assets/js/highchart.js"></script>
<!--<script src="https://code.highcharts.com/highcharts.js"></script>-->
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<br><br>
<!--<div><a href="/Admin/adminStock/0">全て</a> / <a href="/Admin/adminStock/1">農産物</a> / <a href="/Admin/adminStock/2">水産物</a> / <a href="/Admin/adminStock/3">畜産物</a></div>
-->
<div><a onclick="con1()" style="cursor: pointer">農産物</a> / <a onclick="con2()" style="cursor: pointer">水産物</a> / <a onclick="con3()" style="cursor: pointer">肉類</a> / <a onclick="con0()" style="cursor: pointer">全て</a></div><br>
<div id="container0" style="width: 1150px; height: 850px; margin: 0 auto; display: none"></div>
<div id="container1" style="width: 1100px; height: 800px; margin: 0 auto; display: none"></div>
<div id="container2" style="width: 1100px; height: 800px; margin: 0 auto; display: none"></div>
<div id="container3" style="width: 1100px; height: 800px; margin: 0 auto; display: inline"></div>


<div class="container">
    <!-- 모달 팝업 -->
    <div class="modal fade" id="orderStart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" style="width: 540px">
            <div class="modal-content">
                <div class="order_modal-body" style="text-align: center">
                </div>
                <input type="text" id="flocationX" style="display:none;"><input type="text" id="flocationY"
                                                                                style="display: none">
                <input type="text" id="flocation2" style="display: none;">
                <div id="map_canvas" style="margin: 0 auto; margin-bottom: 20px; width: 460px; height: 400px;"></div>
            </div>
        </div>
    </div>
</div>

<br>
<br>
<div class="showcase">
    <div id="content-5" class="content horizontal-images light" style="	background-color: #F2FFED; font-family: Meiryo;">
        <form method="post" action="/Admin/corderDB">
        <div id="drag_box1" ondrop="drop(event)" ondragover="allowDrop(event)"
             style="min-width: 1000px; min-height: 140px">
            <div id="first_logo" draggable="false"><img id="first_logo_img" draggable="false"
                                                                       src="/public/assets/img/corder/kototakuhai.jpg" width="150" height="90" style="border-radius: 20px"/>
                <p draggable="false" align="center">配達希望日<br>
                <input required draggable="false" type="date" value="<?php $kss['date'] = date('Y-m-d'); echo date("Y-m-d", strtotime($kss['date'].' + 2day')); strtotime(date('Y-m-d').' + 2day');?>" min="<?php $kss['date'] = date('Y-m-d'); echo date("Y-m-d", strtotime($kss['date'].' + 2day')); strtotime(date('Y-m-d').' + 2day');?>" style=" height: 20px; width: 150px; margin-bottom: 10px; text-align: center" name='cotime'><br>
                    <input type="submit" value="取り引き" name="submit_admin_corder" draggable="false" style="padding: 4px 5px; width: 150px; height: 25px"></p>
            </div>
            <?php foreach ($material_stock_info as $row) {
                if ($row->mstock <= $row->danger) { ?>
                    <div id="drag_<?= $row->cno ?>" draggable="false" ondragstart="drag(event)" align="center" class="drag_crop">
                <span draggable="false" data-toggle="modal" data-target="#orderStart" class="order_start_btn"
                      id="cno<?= $row->cno ?>"
                      onclick="ajax(<?= $row->mno ?>)">
                  <img id="img_<?= $row->cno ?>" draggable="true" class="drag"
                       src="/public/assets/img/crops/<?= $row->cpname ?>">
                   <p id="drag_name_<?= $row->cno ?>" draggable="false"
                      style="color: black; margin: 0; text-align: center; line-height: 22px"><?= $row->cname ?><br>(<?= $row->fname ?>)
                  </p>
                </span>
                        <p id="drag_order_<?= $row->cno ?>" draggable="false" style="margin-top: 3px; font-size: 15px; width: 146px">量 &nbsp;&nbsp;&nbsp;<input id="drag_num_<?= $row->cno ?>" draggable="false" type="number" name="costock[<?= $row->cno ?>]" style="width: 50px; height: 20px; font-size: 12pt; text-align: center" min="1" value="1"> &nbsp;&nbsp;kg</p>
                        <input id="drag_order2" draggable="false" type="hidden" name="cno[<?= $row->cno ?>]" value="<?= $row->cno ?>">
                    </div>
                <?php }
            } ?>
        </div>
        </form>
    </div>
</div>
<div style="margin: 0 auto;">
    <div class="showcase" style="width: 1200px; background-color: #FCF2FF; height: 600px; overflow-y: scroll; padding: 15px; border-radius: 10px; font-family: Meiryo;">
        <div>
            <div style="padding-bottom: 10px"><input class="gate" id="search" type="text" name="search" size="20" onkeyup="showResult(this.value)" placeholder="名で探す" required></div>
        </div>
        <div id="content-2">
            <div id="drag_box2" ondrop="drop(event)" ondragover="allowDrop(event)"
                 style="min-width: 100%; min-height: 400px">
                <div id="second_logo" draggable="false" class="seiri"><img id="second_logo_img" draggable="false"
                                                                           src="/public/assets/img/corder/songarak.gif" width="146" height="130" style="border-radius: 20px"/>
                </div>
                <?php foreach ($material_stock_info as $row) {
                    if ($row->mstock > $row->danger) { ?>
                        <div id="drag_<?= $row->cno ?>" draggable="false" ondragstart="drag(event)" class="drag_crop">
                <span draggable="false" data-toggle="modal" data-target="#orderStart" class="order_start_btn"
                      id="cno<?= $row->cno ?>"
                      onclick="ajax(<?= $row->mno ?>)">
                  <img id="img_<?= $row->cno ?>" draggable="true" class="drag"
                       src="/public/assets/img/crops/<?= $row->cpname ?>">
                  <p id="drag_name_<?= $row->cno ?>" draggable="false"
                     style="color: black; margin: 0; text-align: center; line-height: 22px"><?= $row->cname ?><br>(<?= $row->fname ?>)
                  </p>
                </span>
                            <p id="drag_order_<?= $row->cno ?>" draggable="false" style="margin-top: 3px; font-size: 15px; display: none;">量 &nbsp;&nbsp;&nbsp;<input id="drag_num_<?= $row->cno ?>" draggable="false" type="number" name="costock[<?= $row->cno ?>]" style="width: 50px; height: 20px; font-size: 12pt; text-align: center" min="1" value="1"> &nbsp;&nbsp;kg</p>
                            <input draggable="false" type="hidden" name="cno[<?= $row->cno ?>]" value="<?= $row->cno ?>">
                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    </div>
</div>

<!-- custom scrollbar plugin -->
<script src="/public/assets/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>

<script type="text/javascript"
        src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA_axHBxQ6umODvtNYo08r993dpfUTplZ4&language=ja&region=jp">
</script>
<script type="text/javascript">

    var map;
    var infowindow = new google.maps.InfoWindow();
    var geocoder;
    var geocodemarker = [];

    function initialize() {

        var a = document.getElementById("flocationX").value;
        var b = document.getElementById("flocationY").value;

        var latlng = new google.maps.LatLng(a, b);   // 서울 : 37.5240220, 126.9265940  지도의 처음위치 표시 ( 현 도쿄)
        var myOptions = {
            zoom: 16,
            center: latlng,
            mapTypeControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        geocoder = new google.maps.Geocoder();

        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: 'Hello World!'
        });

        geocoder.geocode({'latLng': latlng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                    //infowindow = 주소 표시
                    var cnt = results[0].address_components.length;

                }
            }
        });
    }
    google.maps.event.addDomListener(window, "resize", resizingMap());

    $('#orderStart').on('show.bs.modal', function () {
        setTimeout(function () {
            initialize();
        }, 800);


        //Must wait until the render of the modal appear, thats why we use the resizeMap and NOT resizingMap!! ;-)
        resizeMap();
    });

    function Setmarker(latLng) {

        if (geocodemarker.length > 0) {
            geocodemarker[0].setMap(null);
        }
// marker.length는 marker라는 배열의 원소의 개수입니다.
// 다른 지점을 클릭할 때 기존의 마커를 제거

        geocodemarker = [];
        geocodemarker.length = 0;
// marker를 빈 배열로 만들고, marker 배열의 개수를 0개로 만들어 marker 배열을 초기화

        geocodemarker.push(new google.maps.Marker({
            position: latLng,
            map: map
        }));
// marker 배열에 새 marker object를 push 함수로 추가합니다.
    }
    // 클릭한 지점에 마커 표시
    //입력 받은 주소를 지오코딩 요청하고 결과를 마커로 지도에 표시합니다.

    function codeAddress(event) {

        if (geocodemarker.length > 0) {
            for (var i = 0; i < geocodemarker.length; i++) {
                geocodemarker[i].setMap(null);
            }
            geocodemarker = [];
            geocodemarker.length = 0;
        }

        var address = document.getElementById("flocation").value;
        //아래의 주소 입력창에서 받은 정보를 address 변수에 저장합니다.;
        //지오코딩하는 부분입니다.
        geocoder.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK)  //Geocoding 성공시
            {

                infowindow.setContent(results[0].formatted_address);
                map.setCenter(results[0].geometry.location);
                geocodemarker.push(new google.maps.Marker({
                    center: results[0].geometry.location,
                    position: results[0].geometry.location,
                    map: map
                }));
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, geocodemarker[0]);
                //결과를 지도에 marker에 표시합니다.
                var cnt = results[0].address_components.length;
                console.log(results[0].address_components[cnt - 2].long_name);
                console.log(results[0].address_components[cnt - 3].long_name);
                console.log(results[0].address_components[0].long_name);
                console.log(results[0].geometry.location.lat());
                console.log(results[0].geometry.location.lng());
            }
            else {
                alert("그 주소에 맞는 장소정보가 없습니다:" + address);

            }
        });
    }


    //클릭 시 주소 반환
    function codeCoordinate(event) {

        //이벤트 발생 시 그 좌표에 마커 생성

        // 좌표를 받아 reverse geocoding 실행
        geocoder.geocode({'latLng': event.latLng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, geocodemarker[0]);
                    //infowindow = 주소 표시
                    var cnt = results[0].address_components.length;
                    console.log(results[0].address_components[cnt - 2].long_name);
                    console.log(results[0].address_components[cnt - 3].long_name);
                    console.log(results[0].address_components[0].long_name);
                    console.log(results[0].geometry.location.lat());
                    console.log(results[0].geometry.location.lng());

                }
            }
        });
    }

    function position() {
        var pos = geocodemarker[0].getPosition();

        //alert(pos.lat()+"/"+pos.lng());
        //return {x:pos.lat(), y:pos.lng()};

        var position = pos.lat() + "/" + pos.lng();

        document.getElementById("position").value = position;
    }

    function resizeMap(myLatLng, marker) {
        if (typeof map == "undefined") return;
        setTimeout(function () {
            resizingMap(myLatLng, marker);
        }, 1300);
    }

    function resizingMap(myLatLng, marker) {
        if (typeof map == "undefined") return;
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");

        map.setCenter(center);
    }

    (function ($) {
        $(window).load(function () {
            $("#content-5").mCustomScrollbar({
                axis: "x",
                theme: "dark-thin",
                autoExpandScrollbar: true,
                advanced: {autoExpandHorizontalScroll: true}
            });
        });
    })(jQuery);

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        console.log(ev.target.id);
        /* 들어갈 곳 */
        console.log(document.getElementById(data));
        /* 잡고있는 거 */
        //ev.target.appendChild(document.getElementById(data));

        var target_box = $(document.getElementById(ev.target.id));
        var get_id = $(document.getElementById(data))[0].parentNode.parentNode.id;

        var getbox = $(document.getElementById(get_id));
        //console.log($(document.getElementById(ev.target.id)));
        //console.log(getbox[0].childNodes[3]);
        var child_id = getbox[0].childNodes[3].id;
        //console.log(getbox[0].childNodes[1].childNodes[1].id);
        var child2 = getbox[0].childNodes[1].childNodes[1].id;
        //console.log(child2);
        //console.log(ev.target.parentNode.id);
        var parents = ev.target.parentNode.id;
        var parents2 = ev.target.parentNode.parentNode.id;
        if(getbox[0].id == target_box[0].id) {

        } else if(get_id == parents || get_id == parents2) {

        } else if(ev.target.id == child2) {

        } else if (ev.target.id == "drag_box1") {
            if(getbox[0].parentNode.id == "drag_box2"){
                displayon(child_id);
            }
            ev.target.appendChild(document.getElementById(get_id));
        } else if ( ev.target.id == "drag_box2") {
            if(getbox[0].parentNode.id == "drag_box1") {
                displayoff(child_id);
                //var parent_id = getbox[0];

                //parent_id.removeChild(child_id);
            }
            ev.target.appendChild(document.getElementById(get_id));
        } else if (target_box.parent()[0].id == "first_logo" || ev.target.id == "first_logo") {
            if(getbox[0].parentNode.id == "drag_box2") {
                displayon(child_id);
            }
            $("#first_logo").after(document.getElementById(get_id));
        } else if (target_box.parent()[0].id == "second_logo" || ev.target.id == "second_logo") {
            if(getbox[0].parentNode.id == "drag_box1") {
                displayoff(child_id);
            }
            $("#second_logo").after(document.getElementById(get_id));
        }
        else {
            var tar = $("#" + ev.target.parentNode.id).prev();
            var tar2 = $("#" + ev.target.parentNode.parentNode.id).prev();
            if (target_box.parent()[0].id == "drag_box1" || target_box.parent().parent()[0].id == "drag_box1" || target_box.parent().parent().parent()[0].id == "drag_box1") {
                if(getbox[0].parentNode.id == "drag_box2"){
                    displayon(child_id);
                }
                if (target_box.parent()[0].id == "drag_box1") {
                    $("#" + ev.target.id).before(document.getElementById(get_id));
                } else if (target_box.parent().parent()[0].id == "drag_box1") {
                    if(tar[0].id == "first_logo") {
                        if(getbox[0].parentNode.id == "drag_box2") {
                            $("#first_logo").after(document.getElementById(get_id));
                        }
                    } else {
                        $("#" + ev.target.parentNode.id).before(document.getElementById(get_id));
                    }
                } else {
                    if(tar2[0].id == "first_logo") {
                        if(getbox[0].parentNode.id == "drag_box2") {
                            $("#first_logo").after(document.getElementById(get_id));
                        }
                    } else {
                        $("#" + ev.target.parentNode.parentNode.id).before(document.getElementById(get_id));
                    }
                }
            } else {
                if(getbox[0].parentNode.id == "drag_box1") {
                    displayoff(child_id);
                }
                if (target_box.parent()[0].id == "drag_box2") {
                    $("#" + ev.target.id).before(document.getElementById(get_id));
                } else if (target_box.parent().parent()[0].id == "drag_box2") {
                    if(tar[0].id == "second_logo") {
                        if(getbox[0].parentNode.id == "drag_box1") {
                            $("#second_logo").after(document.getElementById(get_id));
                        }
                    } else {
                        $("#" + ev.target.parentNode.id).before(document.getElementById(get_id));
                    }
                } else {
                    //console.log("#" + ev.target.parentNode.parentNode.id);
                    if(tar2[0].id == "second_logo") {
                        if(getbox[0].parentNode.id == "drag_box1") {
                            $("#second_logo").after(document.getElementById(get_id));
                        }
                    } else {
                        $("#" + ev.target.parentNode.parentNode.id).before(document.getElementById(get_id));
                    }
                }
            }
            /*if (getbox.parent().parent()[0].id == "drag_box2" || getbox.parent()[0].id == "drag_box2" || getbox.parent().parent().parent()[0].id == "drag_box2") {
             if (ev.target.id == "") {
             //$("#ssibal").prepend(document.getElementById(data));
             //console.log(ev.target.parentNode.id);
             $("#" + ev.target.parentNode.id).before(document.getElementById(data));
             } else {
             $("#" + ev.target.id).before(document.getElementById(data));
             }

             } else if (target_box[0] == "drag_box1") {

             window.alert(ev.target.id);

             ev.target.appendChild(document.getElementById(data));

             } else {
             if (ev.target.id == "") {
             //$("#ssibal").prepend(document.getElementById(data));
             //console.log(ev.target.parentNode.id);
             $("#" + ev.target.parentNode.id).before(document.getElementById(data));
             } else {
             $("#" + ev.target.id).before(document.getElementById(data));
             }

             }*/
        }
    }
    function displayon(id) {
        var display = document.getElementById(id);
        display.style.display = "inline";
    }
    function displayoff(id) {
        var display = document.getElementById(id);
            //console.log(display);
            display.style.display = "none";
    }

    function showResult(value) {

        var box = $(document.getElementById("drag_box2"));
        var length = box[0].childNodes.length;
        var div = box[0].getElementsByTagName("div");
        var div_length = div.length;

        if(value.length > 0) {
            $.post("/Admin/liveSearch", {search_data:value},function(data){
                //box.removeChild(box[0].getElementsByTagName("text"));
                //console.log(box[0].getElementsByTagName("text"));
                //var length2 = $("#drag_box2 > div").size();
                if(data == "none") {
                    for(var i = 1; i < div_length; i++) {
                        displayon(div[i].id);
                    }
                } else {
                    //console.log(box[0].childNodes);
                    //console.log(length2);
                    var cno = data.split('/');
                    //$("#livesearch").html(cno[0]);
                    //console.log(cno.length);
                    for(var i = 1; i < div_length; i++) {
                        if(div[i].id) {
                            displayoff(div[i].id);
                        }
                    }
                    for(var i = 0; i < cno.length; i++) {
                        for(var j = 1; j < div_length; j++) {
                            //console.log(div[j].id);
                            if(div[j].id) {
                                if(div[j].id == "drag_" + cno[i]) {
                                    //console.log("drag_" + cno[i] + "on");
                                    displayon("drag_" + cno[i]);
                                }
                            }
                        }
                    }
                }
            });
        } else {
            for(var i = 1; i < div_length; i++) {
                displayon(div[i].id);
            }
        }

    /*if (str.length==0) {
        document.getElementById("livesearch").innerHTML="";
        document.getElementById("livesearch").style.border="0px";
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
            document.getElementById("livesearch").style.border="1px solid #A5ACB2";
        }
    };
    xmlhttp.open("POST","/admin/liveSearch/"+str,true);
    xmlhttp.setRequestHeader("Content-Type", "application/json");//URL : 경로
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
    console.log(xmlhttp);
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
            $("." + list_tag_class).html(xmlhttp.responseText);

        }
    }
    xmlhttp.send();*/

        /*$.post("/Admin/liveSearch", {par:str}, function() {
            $("livesearch").html(data);
        })*/
        
    }

    function con0() {
        displayoff("container1");
        displayoff("container2");
        displayoff("container3");
        displayon("container0");
    }

    function con1() {
        displayoff("container0");
        displayoff("container2");
        displayoff("container3");
        displayon("container1");
    }

    function con2() {
        displayoff("container1");
        displayoff("container0");
        displayoff("container3");
        displayon("container2");
    }

    function con3() {
        displayoff("container1");
        displayoff("container2");
        displayoff("container0");
        displayon("container3");
    }

    /*$("#search").keyup(function (e) {
        $("here").show();
        var x = $(this).val();
        $.ajax(
            {
                type: 'POST',
                url: '/Admin/liveSearch',
                data: "q=" + x,
                dataType:'json',
                success: function (data) {
                    $("#here").html(data);
                },
                error: function() {
                    //window.alert('오류가 발생하였습니다.');
                }
            }
        )
        })*/
</script>