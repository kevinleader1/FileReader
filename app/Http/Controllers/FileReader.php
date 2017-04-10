<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileReader extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // url du fichier / dossier $url = Storage::url('file1.jpg');
        // La taille du fichier : $size = Storage::size('file1.jpg');
        // La dernière fois modif : $time = Storage::lastModified('file1.jpg');

        // on ajoute un éventuel nom de dossier à public
        //$NameGlobalDir = '/public/'.$request ;

        $NameGlobalDir = '/public/'.$request->getRequestUri() ;

        // On récupère les dossiers contenu dans le storage public
        $DirectoryRepertory = Storage::directories($NameGlobalDir);
        // On récupère les fichier contenu dans le dossier que l'on appel
        $urlFile = Storage::files($NameGlobalDir) ;

        // On va ignorer les .gitignore et les .htaccess du fichier principale
        $urlFile = array_filter($urlFile , function ($files) {
            // On récupère le dossier que l'on désire
            return !in_array($files, ['public/.gitignore', 'public/.htacesss']);
        });


        // On veut supprimer le public/ qui n'est pas utilie dans ce contexte
        $DirectoryRepertory = array_map(function($item){
           return str_replace('public/' , '' , $item) ;
        } , $DirectoryRepertory) ;

        // Idem pour l'url du fichier
        $urlFile = array_map(function($item){
            return str_replace('public/' , '' , $item) ;
        } , $urlFile) ;

        // On récupère les noms des fichiers
        $NameFile = array_map(function($item){
            return basename($item) ;
        } , $urlFile) ;

        // On va créer à la fin le tableau json
        $tableau_json = array(

            'dirName' => $DirectoryRepertory ,
            'urlFile' => $urlFile ,
            'NameFile' => $NameFile ,
            'UrlCourant' => $request->getRequestUri() ,
        ) ;

        // Mettre le tableau sous format json pour récupérer avec vue js
        $tableau_json = json_encode($tableau_json) ;

        // Si c'est de l'ajax on retourne que le tableau, sinon on retourne également la vue
        if($request->ajax()){
            return $tableau_json;
        }else{
            return view('welcome' , ['repertory' => $tableau_json]) ;
        }
    }

    /**
     * @param $fichier
     * @return string
     */
    public function readFile($fichier){

        // On récupère le fichier courant du fichier
        $pathFile = storage_path('app/public/'.$fichier) ;

        // On va récupérer le contenu du fichier que l'on désire au format json
        $contentFile = file_get_contents($pathFile) ;
        // On supprime les espaces du début
        $contentFile = trim($contentFile) ;

        // On créé le tableau qui récupère des informations sur le fichier
        $DonneesFile = array(
            'name' => $fichier , 
            'content' => $contentFile ,
            'size' => filesize($pathFile)
        ) ;

        return json_encode($DonneesFile);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Pour modifier le contenu Storage::put('test.txt', 'bonsoir');
        // bouger un fichier : Storage::move('old/file1.jpg', 'new/file1.jpg');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // supprimer des fichiers Storage::delete('file.jpg');
    }
}
