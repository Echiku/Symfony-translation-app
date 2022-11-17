<?php

namespace App\Controller;

use App\Service\TranslatorService;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    
    private $translator;

    public function __construct( TranslatorService $translator)
    {
      $this->translator=$translator;
    }
    #[Route('/', name: 'app_home')]
    public function index(? string $text_to_translate, ? string $text_translated, ? string $source_lang,? string $target_lang): Response
    {
      //limit=136 character;
      $tab_lang=json_decode(file_get_contents($this->getParameter('kernel.project_dir').'/public/lang.code.json'),true);
      

      
      if($source_lang && $target_lang)
      {

        foreach($tab_lang['lang'] as $tb)
        {
           
            if($tb['name'] == $source_lang)
            {
               $leftLang= array_unique(array_merge(array('0'=>$tb),$tab_lang['lang']),SORT_REGULAR);
            }

            if($tb['name'] == $target_lang)
            {
                $rightLang= array_unique(array_merge(array('0'=>$tb),$tab_lang['lang']),SORT_REGULAR);
            }
        }
       
      }

      else 
      {
        $leftLang=$tab_lang['lang'];
        $rightLang=array_reverse($tab_lang['lang'],true);
      }

    
    

        return $this->render('home/index.html.twig',
           [
            'right_lang'=>$rightLang,
            'left_lang'=>$leftLang,
            'text_to_translate'=>$text_to_translate,
            'text_translated'=>$text_translated
           ]
        );
    }

    #[Route('/switch', name: 'app_switch', methods:'POST')]
    public function switch(Request $request): Response
    {

          $data=json_decode($request->getContent(),true);

          
          $lang_source=$data['lelang'];
          $lang_target=$data['rlang'];
          $text=$data['text'];

          $translation=$this->translator->translation($lang_source,$lang_target,$text);

          $table=
          [
            'text_send'=>$text,
            'text_translated'=>$translation
          ];
          
          return $this->json($table);
       
    }

    #[Route('/translate', name: 'app_translate', methods:'POST')]
    public function translate(Request $request): Response
    {
         
         $lang_source=$request->request->get('left-lang');
        
         $lang_target=$request->request->get('right-lang');

         $text=$request->request->get('textsend');

         $translation=$this->translator->translation($lang_source,$lang_target,$text);
      

         return $this->forward('App\Controller\HomeController::index',
               [
                'text_to_translate'=>$text,
                'text_translated'=>$translation,
                'source_lang'=> $request->request->get('left-lang'),
                'target_lang'=> $request->request->get('right-lang')
               ]
               );

    }

   
}
