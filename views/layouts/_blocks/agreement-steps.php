<div class="agreement-steps">
    <!-- <div class="agreement-steps__item agreement-steps__item--done">
        <p>Сроки и участники</p>
    </div>-->
    <div class="agreement-steps__mobile">
        <div class="agreement-steps__m-title">
            <?php echo $stepsItems[$stepsItemCurrent] ?>
        </div>
        <div class="agreement-steps__m-counter">
            <svg class='b-counter-circle' xmlns="http://www.w3.org/2000/svg">
                <circle cx="20" cy="20" r="15" stroke="#e5e5e5" stroke-width="1" fill="transparent"  />
                <circle cx="20" cy="20" r="16" stroke="#ffc00f" stroke-width="2" fill="transparent" stroke-dasharray='30,100' stroke-dashoffset='100' />
                <!-- <path 
                    stroke="#ffc00f" 
                    stroke-width="2"
                    fill="transparent"
                    d='M5,20a15,15 0 1,0 30,0a15,15 0 1,0 -30,0' 
                    stroke-dasharray='0 ,100'
                    stroke-dashoffset='0'
                />    -->
                <text x="16px" y="25" font-family="Verdana" font-weight='normal' font-size="15"><?php  echo $stepsItemCurrent+1; ?></text>
            </svg>
        </div>
    </div>

    <div class="agreement-steps__items">
        <?php if($stepsItems):?>
            <?php foreach($stepsItems as $key=>$value):?>

                <div class="agreement-steps__item 
                    <?php if($key <= $stepsItemDoneCount){echo 'agreement-steps__item--done';}?>
                    <?php if($key === $stepsItemCurrent){echo 'agreement-steps__item--current';}?>
                    <?php if($key > $stepsItemCurrent){echo 'agreement-steps__item--after';}?>
                ">
                    <p><?php echo $value;?></p>
                </div>

            <?php endforeach;?>
        <?php endif;?>
    </div>
</div>