<?php
namespace App\Service;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TranslatorService
{


    private $params;

   public function __construct(ParameterBagInterface $params)
   {
        $this->params=$params;
   }

    public function translation($LeftLang,$rightLang,$textSend): string
    {
        //Json Language file
        $tab_lang=json_decode(file_get_contents($this->params->get('kernel.project_dir').'/public/lang.code.json'),true);
         
        $lang_source=$LeftLang;

         //get the value correspondant

         foreach($tab_lang['lang'] as $tab)
         {
            if($tab['name'] ==$lang_source)
                {
                  $lang_source=$tab['code'];
                  
                }
           

         }

         $lang_target=$rightLang;
         //get the value correspondant

         foreach($tab_lang['lang'] as $tab)
         {
            if($tab['name'] ==$lang_target)
            {
              $lang_target=$tab['code'];
              
            }
           

         }

         $pipeline=new GoogleTranslate();

         $pipeline->setSource($lang_source);

         $pipeline->setTarget($lang_target);

         $translation=$pipeline->translate($textSend);

        return $translation;
    }
}