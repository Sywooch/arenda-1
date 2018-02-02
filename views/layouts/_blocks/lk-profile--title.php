<div class="lk-profile-t">
    <?php if($lkProfileTxt): ?>
        <h1 class='lk-profile-t__title'><?php echo $lkProfileTxt['title'];?></h1>
        <p class="lk-profile-t__sub"><?php echo $lkProfileTxt['subtitle'];?></p>
    <?php endif;?>
    <?php if(isset($lkProfileBtn)): ?>
        <div class="lk-profile-t__btn btn btn-y"><?php echo $lkProfileBtn['btn'];?></div>
    <?php endif;?>
</div>