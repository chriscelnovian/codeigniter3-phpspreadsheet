<!-- Modal Import Excel -->
<div id="modalImport" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= site_url('home/import_excel') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mb-3">

                    <!-- Upload File -->
                    <input name="uploadFile" class="form-control mb-1" type="file" accept=".xls,.xlsx,.csv" required>

                    <!-- Download Template -->
                    <a href="<?= base_url('assets/excel/template.xlsx') ?>" class="float-right" download>Download Template</a>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>