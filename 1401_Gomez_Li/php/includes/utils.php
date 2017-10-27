<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function print_film($films){
     echo '<div class="responsive">
                    <div class="gallery">
                        <a href="product.php?id=' . $films->id . '">
                        <img src=' . $films->poster . ' alt="imagen" width="100" height="100">
                    </a>
                        <div class="desc">
                            <a href="product.php?id=' . $films->id . '">
                            <b>' . $films->titulo . '</b>
                        </a>
                            <br>' . $films->director . '</div>
                    </div>
                </div>';
     return;
}
?>