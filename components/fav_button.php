                
                <?php if (!fetch_record($check_faves . $post['id'])): ?>
                    <button id='favorite' onclick=<?php echo "favorite(" . $post['id'] . "," . $post['userid'] . ")";?>>Add to favorites</button>
                <?php else: ?>
                    <button id='unfavorite' onclick=<?php echo "unfavorite(" . $post['id'] . ")";?>>Remove from favorite</button>
                <?php endif;?>
        