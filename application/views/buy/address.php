<?php
$length = count($addressList) - 1;
if ($addressList) { ?>
    <h3>주소록 <input type="button" value="변경" data-toggle="modal" data-target="#myModal"></h3>
    <form method="post" action="/Buy/buy">
        <div class="recipebox">
            이름<input type="text" name="recipient" value="<?php echo $addressList[$length]->recipient ?>"><br>
            우편번호<input type="text" name="postcode" value="<?php echo $addressList[$length]->postcode ?>"><br>
            상세주소<input type="text" name="ad1" value="<?php echo $addressList[$length]->ad1 ?>"><br>
            <input type="text" name="ad2" value="<?php echo $addressList[$length]->ad2 ?>"><br>
            멘션이름<input type="text" name="menstion" value="<?php echo $addressList[$length]->menstion ?>"><br>
            핸드폰<input type="text" name="telephone" value="<?php echo $addressList[$length]->telephone ?>"><br>
            <input type="submit" value="결제">
        </div>
        <input type="hidden" name="oprice" value="<?php echo $oprice ?>">
        <input type="hidden" name="owishday" value="<?php echo $owishday ?>">
        <input type="hidden" name="rno" value="<?php echo $rno ?>">
    </form>
<?php } else { ?>

    <h1>주소록 등록</h1>
    <form method="post" action="/Buy/addressAdd">
        <div class="recipebox">
            이름<input type="text" name="recipient"><br>
            우편번호<input type="text" name="postcode"><br>
            상세주소<input type="text" name="ad1"><br><input type="text" name="ad2"><br>
            멘션이름<input type="text" name="menstion"><br>
            핸드폰<input type="text" name="telephone"><br>
            <input type="submit" value="등록">
        </div>

    </form>
<?php } ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">주소록</h4>
            </div>
            <div class="modal-body">
                <?php foreach ($addressList as $address) { ?>
                    <div>
                        <form method="post" action="/Buy/address_change" id="addressList">
                            <input type="hidden" name="ano" value="<?php echo $address->ano ?>">
                            이름 <input type="text" name="recipient" value="<?php echo $address->recipient ?>">
                            핸드폰 <input type="text" name="telephone" value="<?php echo $address->telephone ?>" >
                            우편번호 <input type="text" name="postcode" value="<?php echo $address->postcode ?>" >
                            주소<input type="text" name="ad1" value="<?php echo $address->ad1 ?>">
                            <input type="text" name="ad2" value=" <?php echo $address->ad2 ?>">
                            멘션이름<input type="text" name="menstion" value="<?php echo $address->menstion ?>" >
                            <button type="submit">변경</button>
                            <button>취소</button>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>