<?=$render('header', ['loggedUser'=>$loggedUser]);?>
<section class="container main">
    <?=$render('sidebar', ['activeMenu' => 'config']);?>

    <section class="feed mt-10">   

        <div class="row">
            <div class="column pr-5">     
                <form class="form-config" enctype='multipart/form-data' method="post">
                    

                    <label for="photo">Nova Foto:</label>                    
                    <input type="file" name="photo" id="photo" accept="image/x-png,image/jpeg">

                    <label for="cover">Nova Capa:</label>                    
                    <input type="file" name="cover" id="cover" accept="image/x-png,image/jpeg">
                    <hr>
                    <?php if(!empty($flash)): ?>
                        <div class="flash"><?=$flash;?></div>
                    <?php endif; ?>
                    <label for="name">Nome Completo:</label>
                    <input type="text" name="name" id="name" value="<?=$loggedUser->name;?>">
                    
                    <label for="birthdate">Data de Nascimento:</label>
                    <input type="text" name="birthdate" id="birthdate" value="<?=date('d/m/Y', strtotime($loggedUser->birthdate));?>">
                    
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" value="<?=$loggedUser->email;?>">
                    
                    <label for="city">Cidade:</label>
                    <input type="text" name="city" id="city" value="<?=$loggedUser->city;?>">
                    
                    <label for="work">Trabalho:</label>
                    <input type="text" name="work" id="work" value="<?=$loggedUser->work;?>">
                    <hr>
                    <label for="password">Nova Senha:</label>
                    <input type="password" name="password" id="password">

                    <label for="confirmPassword">Confirmar Nova Senha:</label>
                    <input type="password" name="confirmPassword" id="confirmPassword">

                    <!-- <input class="button" type="submit" value="Salvar"> -->
                    <button class="button">Salvar</button>
                    
                </form>              
            </div>
            <div class="column side pl-5">
                <?=$render('right-side');?>
            </div>
        </div>
    </section>
</section>
<script src="https://unpkg.com/imask"></script>
<script>
    IMask(
        document.getElementById('birthdate'),
        {
            mask:'00/00/0000'
        }
    );
</script>
<?=$render('footer');?>