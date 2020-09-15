<?php

namespace App\Controllers;

class HomeController extends BaseController
{


	/////////////////////////////
	//                         //
	//	        CRUD           //
	//                         //
	/////////////////////////////

	/**
	 * Pagina inicial do módulo
	 */
	public function index()
	{
		echo view('template/header');
		echo view('home/index');
		echo view('home/functions');
		echo view('template/footer');
	}

	/**
	 * Mostra um item específico
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Retorna a View para criar um item da tabela
	 */
	public function create()
	{
		//
	}

	/**
	 * Salva o novo item na tabela
	 */
	public function store()
	{
		$arquivo = $this->request->getFile('audio_data');
		
		if($arquivo->isValid()){
			$novoNome = $arquivo->getRandomName();
			$arquivo->move('audios', $novoNome);
			$this->response->setJSON('Arquivo salvo: '.$novoNome);
		}else{
			$this->response->setJSON('Falha ao salvar o arquivo');
		}
	}

	/**
	 * Retorna a View para edição do dado
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Salva a atualização do dado
	 */
	public function update()
	{
		//
	}

	/**
	 * Remove ou desabilita o dado
	 */
	public function destroy()
	{
		//
	}

	/////////////////////////////
	//                         //
	//	   Outras funções      //
	//                         //
	/////////////////////////////
}
