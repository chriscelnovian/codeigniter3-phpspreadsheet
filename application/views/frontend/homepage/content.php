<!-- Content Page -->
<div class="container">
    
    <!-- Header -->
    <div class="content-header">

        <!-- Import Button -->
        <a data-toggle="modal" data-target="#modalImport" class="btn btn-sm btn-success">
            <i class="fas fa-file-import"></i> Import
        </a>

        <!-- Export Button -->
        <a data-toggle="modal" data-target="#modalExport" class="btn btn-sm btn-primary float-right">
            <i class="fas fa-download"></i> Export
        </a>

    </div>

    <!-- Table Transaction -->
    <div class="table-responsive">
        <table class="table table-striped border">
            <thead class="text-center">
                <th class="border">#</th>
                <th class="border">Name</th>
                <th class="border">Price</th>
                <th class="border">Quantity</th>
                <th class="border">Total</th>
                <th class="border">Date</th>
            </thead>

            <tbody>
                <?php foreach($transaction_list as $key => $transaction) { ?>
                <tr class="text-center">
                    
                    <!-- Number -->
                    <td class="border"><?= $key+1 ?></td>

                    <!-- Name -->
                    <td class="border"><?= $transaction['name'] ?></td>

                    <!-- Price -->
                    <td class="border"><?= number_format($transaction['price']) ?></td>

                    <!-- Quantity -->
                    <td class="border"><?= $transaction['qty'] ?></td>

                    <!-- Total -->
                    <td class="border"><?= number_format($transaction['total']) ?></td>

                    <!-- Date -->
                    <td class="border"><?= $transaction['input_date'] ?></td>
                </tr>
                <?php } ?>

                <!-- Empty State -->
                <?php if(empty($transaction_list)) { ?>
                    <tr class="text-center"><td colspan="4">Data not found</td></tr>
                <?php } ?>

            </tbody>

        </table>
    </div>

</div>

<!-- Load Modal Views -->
<?php 
    $this->load->view('frontend/homepage/modal-export-excel'); 
    $this->load->view('frontend/homepage/modal-import-excel');
?>
