<div class="homepage-container">
    <?php if ($users != NULL): ?>
        <div class="white-box">
            <h3>Followers</h3>
            <?php foreach ($users as $user): ?>
                <?php $this->renderPartial('//user/list', array('user' => $user)); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
