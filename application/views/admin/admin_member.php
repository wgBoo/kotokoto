<section id="admin_member">
    <div style="margin: 0 auto">
        <h2 align="center">会員管理</h2>
        <table border="1" align="center">
            <tr><th>会員番号</th><th>ID</th><th>e-mail</th><th>年齢</th><th>性別</th><th>削除</th></tr>
            <?php foreach($users_info as $row) { ?>
                <tr style="padding: 10px">
                    <td width="10%" align="center"><?= $row->uno ?></td>
                    <td width="20%" align="center"><?= $row->uid ?></td>
                    <td width="30%"><?= $row->email ?></td>
                    <td width="10%" align="center"><?= $row->old ?></td>
                    <td width="10%" align="center"><?php $sex = $row->sex;
                        if($sex == 0) echo "男";
                        else echo "女" ?></td>
                    <td width="10%" align="center"><input type="button" value="削除" onclick="location.href='/Admin/adminDelteMem/<?= $row->uno ?>'" style="margin: 5px; padding: 5px"></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</section>