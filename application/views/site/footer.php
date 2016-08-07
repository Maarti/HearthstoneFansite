<footer class="foot">
    <div class="foot-text">
        <p class="maarti-footer">&copy; <?= date("Y") ?> - Maarti.net</p><br/><br/>
        <p>Blizzard Entertainment is a trademark or registered trademark of Blizzard Entertainment, Inc. in the U.S. and/or other countries.<br/> All rights reserved.</p>
        <p>©1996 - 2011 Blizzard Entertainment, Inc. All rights reserved.<br/> Battle.net and Blizzard Entertainment are trademarks or registered trademarks of Blizzard Entertainment, Inc. in the U.S. and/or other countries.</p>
    </div>
</footer>
<? if(!strpos($url, 'tournament')){?> 
<script src="<?= base_url('assets/js/vendor/jquery.js'); ?>"></script>
<?}?>
<script src="<?= base_url('assets/js/vendor/fastclick.js'); ?>"></script>
<script src="<?= base_url('assets/js/foundation.min.js'); ?>"></script>
<script> $(document).foundation(); </script>
</body>
</html>