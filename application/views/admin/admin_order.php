<section id="admin_order" style="margin: 0 auto; float: inherit">
    <style>
        .ths{
            background: #FFE5C2;
            border-radius: 10px;
            margin: 2px 5px;
        }
        .timg {
            width: 180px;
            height: 130px;
            padding:15px 15px 2px 15px;
            border-radius: 30px;
            cursor:pointer;
        }

        .row > * {
            float: none;
        }
    </style>
    <br>
    <h2 style="text-align: center;">注文現況</h2><br>
    <div><span style='color: red;' onclick="displayon('cl3')">完了 : <?php if(isset($status_info[0])){ echo $status_info[0]->count; } else { echo "0"; } ?> </span> / <a style='color: deepskyblue' onclick="cordering()"> 取引中 : <?php if(isset($status_info2[0])) echo $status_info2[0]->count; else echo "0";  ?></a> / <a>中止 : <?php if(isset($status_info3[0])) echo $status_info3[0]->count; else echo "0";  ?> </a></div>
    <br>
        <table id="table">
            <tr align="center"><th class="ths">品</th><th class="ths">量</th><th class="ths">状態</th><th class="ths">メッセージ</th><th class="ths">希望の日</th><th class="ths">注文の日</th></tr>
            <?php foreach($corders_info as $row) { ?>
            <tr align="center" class="cl1">
                <td style="background-color:<?php if($row->costatus == 0 || $row->costatus == 2) { echo "#F6FFF2";} else if($row->costatus == 1 || $row->costatus == 3) {echo "#F1FFFF";} else if($row->costatus == 4) {echo "#FFF2F2";} else {echo "#F5F5F5";} ?>">
                    <img class="timg" src="/public/assets/img/crops/<?= $row->cpname ?>" onclick="location.href='/Admin/adminOrderDetail/<?= $row->cono ?>'">
                    <br><?= $row->fname ?> - <?= $row->cname ?></td>
                <td style="padding: 10px 15px;"><?= $row->costock ?> kg</td>
                <td style="padding: 0 12px;"><div onclick="location.href='/Admin/adminOrderDetail/<?= $row->cono ?>'"><?php
                    if($row->costatus == 0) {
                        echo "<span style='color: limegreen; cursor: pointer'>取引先への確認中</span>";
                    } else if($row->costatus == 1) {
                        echo "<span style='color: deepskyblue; cursor: pointer'>代金を入金してください</span>";
                    } else if($row->costatus == 2) {
                        echo "<span style='color: limegreen; cursor: pointer'>発送の準備</span>";
                    } else if($row->costatus == 3) {
                        echo "<span style='color: deepskyblue; cursor: pointer'>届いたらボタンを押して確認してください</span>";
                    } else if($row->costatus == 4) {
                        echo "<span style='color: red; cursor: pointer'>終了</span>";
                    } else {
                        echo "<span style='color: black; cursor: pointer'>取引先からへの中止</span>";
                    }
                    ?></div></td>
                <td style="padding: 0 12px;">
                    <?php
                    $cnt = count($message_info);
                    $cnt2 = 0;

                        foreach($message_info as $row2) {
                            $cnt2++;

                            if($row->cono == $row2->cono) {
                                $mchar = strlen($row2->comcontent);
                                if ($mchar > 60) {
                                    $mchar2 = substr($row2->comcontent, 0, 30);
                                    echo "'" . $mchar2 . "...'";
                                } else {
                                    echo "'" . $row2->comcontent . "'";
                                }
                                break;
                            }
                        }
                    ?>
                </td>
                <td style="padding: 0 12px;"><?php
                    $cotime = $row->cotime;
                    $ntime = explode("-", $cotime);

                    echo $ntime[0]."年 ".$ntime[1]."月 ".$ntime[2]."日";
                    ?></td>
                <td style="padding: 0 15px;"><?php
                    $coday = $row->coday;
                    $ncoday = explode("-", $coday);

                    echo $ncoday[0]."年 ".$ncoday[1]."月 ".substr($ncoday[2], 0, 2)."日";
                    ?></td>
            </tr>
            <?php } ?>

            <?php foreach($corders_info2 as $row) { ?>
                <tr align="center" class="cl2">
                    <td style="background-color:<?php if($row->costatus == 0 || $row->costatus == 2) { echo "#F6FFF2";} else if($row->costatus == 1 || $row->costatus == 3) {echo "#F1FFFF";} else if($row->costatus == 4) {echo "#FFF2F2";} else {echo "#F5F5F5";} ?>">
                        <img class="timg" src="/public/assets/img/crops/<?= $row->cpname ?>" onclick="location.href='/Admin/adminOrderDetail/<?= $row->cono ?>'">
                        <br><?= $row->fname ?> - <?= $row->cname ?></td>
                    <td style="padding: 10px 15px;"><?= $row->costock ?> kg</td>
                    <td style="padding: 0 12px;"><div onclick="location.href='/Admin/adminOrderDetail/<?= $row->cono ?>'"><?php
                            if($row->costatus == 0) {
                                echo "<span style='color: limegreen; cursor: pointer'>取引先への確認中</span>";
                            } else if($row->costatus == 1) {
                                echo "<span style='color: deepskyblue; cursor: pointer'>代金を入金してください</span>";
                            } else if($row->costatus == 2) {
                                echo "<span style='color: limegreen; cursor: pointer'>発送の準備</span>";
                            } else if($row->costatus == 3) {
                                echo "<span style='color: deepskyblue; cursor: pointer'>届いたらボタンを押して確認してください</span>";
                            } else if($row->costatus == 4) {
                                echo "<span style='color: red; cursor: pointer'>終了</span>";
                            } else {
                                echo "<span style='color: black; cursor: pointer'>取引先からへの中止</span>";
                            }
                            ?></div></td>
                    <td style="padding: 0 12px;">
                        <?php
                        $cnt = count($message_info);
                        $cnt2 = 0;

                        foreach($message_info as $row2) {
                            $cnt2++;

                            if($row->cono == $row2->cono) {
                                $mchar = strlen($row2->comcontent);
                                if ($mchar > 60) {
                                    $mchar2 = substr($row2->comcontent, 0, 30);
                                    echo "'" . $mchar2 . "...'";
                                } else {
                                    echo "'" . $row2->comcontent . "'";
                                }
                                break;
                            }
                        }
                        ?>
                    </td>
                    <td style="padding: 0 12px;"><?php
                        $cotime = $row->cotime;
                        $ntime = explode("-", $cotime);

                        echo $ntime[0]."年 ".$ntime[1]."月 ".$ntime[2]."日";
                        ?></td>
                    <td style="padding: 0 15px;"><?php
                        $coday = $row->coday;
                        $ncoday = explode("-", $coday);

                        echo $ncoday[0]."年 ".$ncoday[1]."月 ".substr($ncoday[2], 0, 2)."日";
                        ?></td>
                </tr>
            <?php } ?>
            <?php foreach($corders_info3 as $row) { ?>
                <tr align="center" class="cl3">
                    <td style="background-color:<?php if($row->costatus == 0 || $row->costatus == 2) { echo "#F6FFF2";} else if($row->costatus == 1 || $row->costatus == 3) {echo "#F1FFFF";} else if($row->costatus == 4) {echo "#FFF2F2";} else {echo "#F5F5F5";} ?>">
                        <img class="timg" src="/public/assets/img/crops/<?= $row->cpname ?>" onclick="location.href='/Admin/adminOrderDetail/<?= $row->cono ?>'">
                        <br><?= $row->fname ?> - <?= $row->cname ?></td>
                    <td style="padding: 10px 15px;"><?= $row->costock ?> kg</td>
                    <td style="padding: 0 12px;"><div onclick="location.href='/Admin/adminOrderDetail/<?= $row->cono ?>'"><?php
                            if($row->costatus == 0) {
                                echo "<span style='color: limegreen; cursor: pointer'>取引先への確認中</span>";
                            } else if($row->costatus == 1) {
                                echo "<span style='color: deepskyblue; cursor: pointer'>代金を入金してください</span>";
                            } else if($row->costatus == 2) {
                                echo "<span style='color: limegreen; cursor: pointer'>発送の準備</span>";
                            } else if($row->costatus == 3) {
                                echo "<span style='color: deepskyblue; cursor: pointer'>届いたらボタンを押して確認してください</span>";
                            } else if($row->costatus == 4) {
                                echo "<span style='color: red; cursor: pointer'>終了</span>";
                            } else {
                                echo "<span style='color: black; cursor: pointer'>引先からへの中止</span>";
                            }
                            ?></div></td>
                    <td style="padding: 0 12px;">
                        <?php
                        $cnt = count($message_info);
                        $cnt2 = 0;

                        foreach($message_info as $row2) {
                            $cnt2++;

                            if($row->cono == $row2->cono) {
                                $mchar = strlen($row2->comcontent);
                                if ($mchar > 60) {
                                    $mchar2 = substr($row2->comcontent, 0, 30);
                                    echo "'" . $mchar2 . "...'";
                                } else {
                                    echo "'" . $row2->comcontent . "'";
                                }
                                break;
                            }
                        }
                        ?>
                    </td>
                    <td style="padding: 0 12px;"><?php
                        $cotime = $row->cotime;
                        $ntime = explode("-", $cotime);

                        echo $ntime[0]."年 ".$ntime[1]."月 ".$ntime[2]."日";
                        ?></td>
                    <td style="padding: 0 15px;"><?php
                        $coday = $row->coday;
                        $ncoday = explode("-", $coday);

                        echo $ncoday[0]."年 ".$ncoday[1]."月 ".substr($ncoday[2], 0, 2)."日";
                        ?></td>
                </tr>
            <?php } ?>
            <?php foreach($corders_info4 as $row) { ?>
                <tr align="center" class="cl4">
                    <td style="background-color:<?php if($row->costatus == 0 || $row->costatus == 2) { echo "#F6FFF2";} else if($row->costatus == 1 || $row->costatus == 3) {echo "#F1FFFF";} else if($row->costatus == 4) {echo "#FFF2F2";} else {echo "#F5F5F5";} ?>">
                        <img class="timg" src="/public/assets/img/crops/<?= $row->cpname ?>" onclick="location.href='/Admin/adminOrderDetail/<?= $row->cono ?>'">
                        <br><?= $row->fname ?> - <?= $row->cname ?></td>
                    <td style="padding: 10px 15px;"><?= $row->costock ?> kg</td>
                    <td style="padding: 0 12px;"><div onclick="location.href='/Admin/adminOrderDetail/<?= $row->cono ?>'"><?php
                            if($row->costatus == 0) {
                                echo "<span style='color: limegreen; cursor: pointer'>取引先への確認中</span>";
                            } else if($row->costatus == 1) {
                                echo "<span style='color: deepskyblue; cursor: pointer'>代金を入金してください</span>";
                            } else if($row->costatus == 2) {
                                echo "<span style='color: limegreen; cursor: pointer'>発送の準備</span>";
                            } else if($row->costatus == 3) {
                                echo "<span style='color: deepskyblue; cursor: pointer'>届いたらボタンを押して確認してください</span>";
                            } else if($row->costatus == 4) {
                                echo "<span style='color: red; cursor: pointer'>終了</span>";
                            } else {
                                echo "<span style='color: black; cursor: pointer'>引先からへの中止</span>";
                            }
                            ?></div></td>
                    <td style="padding: 0 12px;">
                        <?php
                        $cnt = count($message_info);
                        $cnt2 = 0;

                        foreach($message_info as $row2) {
                            $cnt2++;

                            if($row->cono == $row2->cono) {
                                $mchar = strlen($row2->comcontent);
                                if ($mchar > 60) {
                                    $mchar2 = substr($row2->comcontent, 0, 30);
                                    echo "'" . $mchar2 . "...'";
                                } else {
                                    echo "'" . $row2->comcontent . "'";
                                }
                                break;
                            }
                        }
                        ?>
                    </td>
                    <td style="padding: 0 12px;"><?php
                        $cotime = $row->cotime;
                        $ntime = explode("-", $cotime);

                        echo $ntime[0]."年 ".$ntime[1]."月 ".$ntime[2]."日";
                        ?></td>
                    <td style="padding: 0 15px;"><?php
                        $coday = $row->coday;
                        $ncoday = explode("-", $coday);

                        echo $ncoday[0]."年 ".$ncoday[1]."月 ".substr($ncoday[2], 0, 2)."日";
                        ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</section>