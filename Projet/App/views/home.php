        <main class="home">
            <h1>Smartphones</h1>
            <div class="smartphones">
                <?php if (empty($smartphones)): ?>
                    <p class="noResults">Aucun smartphone trouvé.</p>
                <?php else: ?>
                    <?php foreach ($smartphones as $smartphone): ?>
                        <div class="smartphone">
                            <img src="<?= htmlspecialchars($smartphone['image_url']) ?>" alt="<?= htmlspecialchars($smartphone['name']) ?>">
                            <div class="smartphoneContent">
                                <h2><?= htmlspecialchars($smartphone['name']) ?></h2>
                                <p><?= htmlspecialchars($smartphone['brand']) ?></p>
                                <p><?= htmlspecialchars($smartphone['description']) ?></p>
                                <p><?= htmlspecialchars($smartphone['price']) ?></p>
                                <form action="index.php?page=add_to_cart" method="POST">
                                    <input type="hidden" name="smartphone_id" value="<?= htmlspecialchars($smartphone['id']) ?>">
                                    <input type="hidden" name="quantity" value="1" min="1">
                                    <button type="submit">Ajouter au panier</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
