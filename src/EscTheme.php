<?php

namespace ESC\Luna;

use ESC\Luna\Modules\CitiesModule;
use ESC\Luna\Modules\CommentsModule;
use ESC\Luna\Modules\FilterBlocksModule;
use ESC\Luna\Modules\FiltersModule;
use ESC\Luna\Modules\GoogleFontsModule;
use ESC\Luna\Modules\LazyLoadModule;
use ESC\Luna\Modules\ModelsViewModule;
use ESC\Luna\Modules\PhotosMetaModule;
use ESC\Luna\Modules\ReusableBlocksModule;
use ESC\Luna\Modules\ShortcodeModule;
use ESC\Luna\Modules\WpRegisterModule;
use ESC\Luna\Modules\MegaMenu;
use ESC\Luna\Modules\AcfModule;
use ESC\Luna\Modules\WpmlModule;
use ESC\Luna\Modules\SeoModule;

class EscTheme
{
    public static function initHooks(): void
    {
        WpRegisterModule::registerHooks();
        ReusableBlocksModule::registerHooks();
        GoogleFontsModule::registerHooks();
        FilterBlocksModule::registerHooks();
        PhotosMetaModule::registerHooks();
        ModelsViewModule::registerHooks();
        CommentsModule::registerHooks();
        LazyLoadModule::registerHooks();
        FiltersModule::registerHooks();
        ShortcodeModule::registerHooks();
        MegaMenu::registerHooks();
        AcfModule::registerHooks();
        WpmlModule::registerHooks();
//        SeoModule::registerHooks();
        CitiesModule::registerHooks();
    }
}

