<h1>Clients</h1>

<p><a href="/clients/add">Add new client</a></p>

<table class="pure-table">
    <tr>
        <th>Title</th>
        <th>Component</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>

<?php foreach ($tickets as $ticket): ?>

    <tr>
        <td><?=$ticket->getId() ?></td>
        <td><?=$ticket->getNom() ?></td>

        <td>
            <a href="<?=$router->pathFor('ticket-detail', ['id' => $ticket->getId()])?>">view</a>
        </td>
    </tr>

<?php endforeach; ?>
</table>
