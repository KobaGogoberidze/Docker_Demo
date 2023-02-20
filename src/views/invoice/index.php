<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h2">Invoices list</h1>
</div>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Customer</th>
                <th>Created at</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($invoices as $invoice) : ?>
                <tr>
                    <td><?= $invoice['id'] ?></td>
                    <td><?= $invoice['amount'] ?></td>
                    <td><?= $invoice['customer_id'] ?></td>
                    <td><?= $invoice['created_at'] ?></td>
                </tr>
            <? endforeach ?>
        </tbody>
    </table>
</div>