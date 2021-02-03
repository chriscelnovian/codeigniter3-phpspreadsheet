<!-- Modal Export Excel -->
<div id="modalExport" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="<?= site_url('home/export_excel') ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Export to Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Filter -->
                    <select id="filter" name="filter" class="form-control">
                        <option value="0">All Data</option>
                        <option value="1">Specific Date</option>
                    </select>

                    <!-- Date -->
                    <input id="filter-date" name="date" value="<?= date('Y-m-d') ?>" class="form-control mt-3 d-none" type="date">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Toggle Date Filter -->
<script>
    $(document).on('change', '#filter', function(e){  
        var optionSelected = $(this).find("option:selected");
        var valueSelected  = optionSelected.val();
        var textSelected   = optionSelected.text();

        if(valueSelected == 1) {
            $('#filter-date').removeClass('d-none');
        } else {
            $('#filter-date').addClass('d-none');
        }
    });
</script>