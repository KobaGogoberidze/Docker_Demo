<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h2">Customers list</h1>
</div>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Full name</th>
                <th>Active</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($customers as $customer) : ?>
                <tr>
                    <td><?= $customer['id'] ?></td>
                    <td><?= $customer['email'] ?></td>
                    <td><?= $customer['full_name'] ?></td>
                    <td><?= $customer['is_active'] ?></td>
                </tr>
            <? endforeach ?>
        </tbody>
    </table>
</div>