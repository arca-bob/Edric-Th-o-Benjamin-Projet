<main class="home">
    <h1>Panier</h1>
    <div class="cartList">
        <?php if (empty($carts)): ?>
            <p>Aucun panier trouvé.</p>
        <?php else: ?>
            <?php foreach ($carts as $cart): ?>
                <div class="cart">
                    <h2>Panier ID: <?= htmlspecialchars($cart['id']) ?></h2>
                    <div class="cartItems">
                        <?php if (empty($cart['items'])): ?>
                            <p>Aucun article dans ce panier.</p>
                        <?php else: ?>
                            <table>
                                <tr>
                                    <th>Nom du Smartphone</th>
                                    <th>Quantité</th>
                                    <th>Prix Unitaire</th>
                                    <th>Prix Total</th>
                                    <th>Actions</th>
                                </tr>
                                <?php
                                $totalAmount = 0;
                                $totalQuantity = 0;
                                foreach ($cart['items'] as $item):
                                    $itemTotal = $item['price'] * $item['quantity'];
                                    $totalAmount += $itemTotal;
                                    $totalQuantity += $item['quantity'];
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['smartphone_name']) ?></td>
                                    <td>
                                        <form action="index.php?page=update_item" method="POST">
                                            <input type="hidden" name="item_id" value="<?= htmlspecialchars($item['id']) ?>">
                                            <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>" min="0" onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td><?= htmlspecialchars($item['price']) ?> €</td>
                                    <td><?= htmlspecialchars($itemTotal) ?> €</td>
                                    <td>
                                        <form action="index.php?page=delete_item" method="POST">
                                            <input type="hidden" name="item_id" value="<?= htmlspecialchars($item['id']) ?>">
                                            <button type="submit">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                            <p>Total des produits: <?= htmlspecialchars($totalQuantity) ?></p>
                            <p>Total du panier: <?= htmlspecialchars($totalAmount) ?> €</p>
                        <?php endif; ?>
                    </div>
                    <form action="index.php?page=order" method="POST">
                        <input type="hidden" name="cart_id" value="<?= htmlspecialchars($cart['id']) ?>">
                        <button type="submit">Commander</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>
