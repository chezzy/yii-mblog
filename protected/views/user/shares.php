<div class="homepage-container">
    <?php if ($shares != NULL): ?>
        <div class="white-box">
            <h3><?php echo User::model()->findByPk($shares[0]->author_id)->username; ?>'s shares</h3>
            <?php foreach ($shares as $share): ?>
                <?php $this->renderPartial('//share/share', array('data' => $share)); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
