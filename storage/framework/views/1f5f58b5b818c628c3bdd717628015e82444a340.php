<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-head"><h2 class="text-center p-2"><?php echo e($company->name); ?></h2></div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="<?php echo e($company->image_url); ?>" height="100px" width="100px" alt="https://static.thenounproject.com/png/194055-200.png">
                    </div>
                    <p><?php echo e($company->description); ?></p>
                    <p style="float: right;">Created by <?php echo e($company->created_by_user->name); ?></p>
                    <i id="like_button" style="float: left;"> <?php echo e($company->likes_amount); ?> likes</i>
                    <input type="hidden" id="company_id" value="<?php echo e($company->id); ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\me-gusta-empresas\resources\views/view_company.blade.php ENDPATH**/ ?>