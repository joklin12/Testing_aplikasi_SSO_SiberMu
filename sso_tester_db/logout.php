<?php
/**
 * @package     Testing SSO Sibermu
 * @author      Joko Supriyanto <joko@sibermu.ac.id>
 * @copyright   Copyright (C) Juni 2025 Biro Sistem Informasi SiberMu. All rights reserved.
 * @license     GPLv3
 */
 
session_start();
session_unset();
session_destroy();
header('Location: index.php');
exit;