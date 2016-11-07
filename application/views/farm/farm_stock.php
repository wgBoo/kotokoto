<section id="farm_stock">
    <script type="text/javascript">
        $(function () {
            var categories = "<?= $total_mstock->fname ?>",
                data = [
                    <?php
                    $cnt = 0;?>
                    {
                        y: <?= $total_mstock->smt ?>,
                        color: "<?= $total_mstock->fcolor ?>",
                        drilldown: {
                            name: <?php echo "'".$total_mstock->fname."'"; ?>,
                            categories: [
                                <?php foreach($crops_stock as $row2) {
                                    echo "'".$row2->cname."',";
                            }?>],
                            danger: [<?php foreach($crops_stock as $row2) {
                                    echo "'".$row2->danger."',";
                            }?>],
                            data: [<?php
                                foreach($crops_stock as $row3) {
                                        echo $row3->mstock.", ";
                                }
                                ?>
                            ],
                            color: "<?= $total_mstock->fcolor ?>"
                        }
                    },
                    <?php $cnt++; ?>
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
                    name: categories,
                    y: data[0].y,
                    color: data[0].color
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
                    text: '管理者の食材の残量',
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
                    name: "総合(kg)",
                    data: browserData,
                    size: '30%',
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
                    innerSize: '40%',
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
    </script>
    <script src="/public/assets/js/highchart.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <div id="container0" style="width: 1350px; height: 1050px; margin: 0 auto; display: inline"></div>
</section>