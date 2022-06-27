<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Android extends CI_Controller {

  public function index(){
    if($this->session->userdata('token') == ''){
      return redirect(base_url('android/login'));
    }else{
      if($this->session->userdata('isLoginAdmin') == true){
        $data = [
          'username' => $this->session->userdata('username'),
          'title' => 'Dashboard | Home'
        ];


        $url = base_url('/api/main/menu');
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer '.$this->session->userdata('token')
          )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        // Send the request
        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);

        $getMenu = json_decode($result,true);
        $menu['datamenu'] = $getMenu['data'];
        
      

        $this->load->view('layout/header');
        $this->load->view('layout/sidebarandroid');
        $this->load->view('layout/navbarandroid',$data);
        $this->load->view('home',$menu);
        $this->load->view('layout/footer');
      }
    }
  }

  public function login (){
    if($this->session->userdata('token')){
      return redirect(base_url('android'));
    }
    return $this->load->view('login-android');
  }

  public function register (){
    return $this->load->view('formregister');
  }

  public function prosesRegister(){
    
    $data = [
      'username' => $this->session->userdata('username'),
      'title' => 'android | Register'
    ];
    $dataCreate = [
      'nama'=> $this->input->post('nama'),
      'alamat'=> $this->input->post('alamat'),
      'no_telp'=> $this->input->post('no_telp'),
      'username'=> $this->input->post('username'),
      'password'=> $this->input->post('password'),
      'role'=> 'user',
    ];

          $url = base_url('/api/auth/register');
          $curl = curl_init($url);
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
      
          // curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          //   'Authorization: Bearer '.$this->session->userdata('token')
          //   )
          // );
  
          /* Set JSON data to POST */
          curl_setopt($curl, CURLOPT_POSTFIELDS, $dataCreate);
  
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
          // Send the request
          $result = curl_exec($curl);
          // Free up the resources $curl is using
          curl_close($curl);
  
          $getloker = json_decode($result,true);
          $loker['dataloker'] = $getloker['data'];
  
          

          echo ("<script LANGUAGE='JavaScript'>
          window.alert('Berhasil mendaftar');
          window.location.href='".base_url('android/login')."';
          </script>");
          return;

    
}

  public function prosesLogin(){
    $url = base_url('/api/auth/login');

		$username = $this->input->post('username');
		$password = $this->input->post('password');

    $data = array(
            'username'      => $username,
            'password' => $password 
    );

    $data_string = json_encode($data);

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");

    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string))
    );

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);  // Insert the data

    // Send the request
    $result = curl_exec($curl);

    // Free up the resources $curl is using
    curl_close($curl);

    $cekLogin = json_decode($result,true);

    if(isset($cekLogin['status'])){
      echo ("<script LANGUAGE='JavaScript'>
          window.alert('Invalid Login');
          window.location.href='".base_url('android/login')."';
          </script>");
      return;
    }
    if(isset($cekLogin['token'])){
      if($cekLogin['role'] == 'user'){
        $this->session->set_userdata('token', $cekLogin['token']);
        $this->session->set_userdata('username', $username);
        $this->session->set_userdata('isLoginAdmin', true);
        return redirect(base_url('android'));
      }else{
        $this->session->set_userdata('isLoginAdmin', true);
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('You dont have access');
        window.location.href='".base_url('android/login')."';
        </script>");
        return;
      }
    }
   
  }

  public function logout(){
    if($this->session->userdata('token')){
      session_destroy();
    }
    return redirect(base_url('android/login'));
  }
  public function user(){
    if($this->session->userdata('token') == ''){
      return redirect(base_url('dashboard/login'));
    }else{
      if($this->session->userdata('isLoginAdmin') == true){
        $data = [
          'username' => $this->session->userdata('username'),
          'title' => 'Dashboard | User'
        ];
        $url = base_url('/api/main/users');
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer '.$this->session->userdata('token')
          )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        // Send the request
        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);

        $getUser = json_decode($result,true);
        $user['datauser'] = $getUser['data'];
        
        $this->load->view('layout/header',$data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar',$data);
        $this->load->view('user',$user);
        $this->load->view('layout/footer');
      }
    }
  }

  public function delete_user($id){
    if($this->session->userdata('token') == ''){
      return redirect(base_url('dashboard/login'));
    }else{
      if($this->session->userdata('isLoginAdmin') == true){
        $url = base_url('/api/main/users/id/'.$id);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer '.$this->session->userdata('token')
          )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        // Send the request
        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);
        $deleteUser = json_decode($result,true);
        if($deleteUser['status'] == 200){
          echo ("<script LANGUAGE='JavaScript'>
          window.alert('User deleted!');
          window.location.href='".base_url('dashboard/user')."';
          </script>");
        }else{
          echo ("<script LANGUAGE='JavaScript'>
          window.alert('Failed to delete');
          window.location.href='".base_url('dashboard/user')."';
          </script>");
        }

      }
    }
  }

  public function menu(){
    if($this->session->userdata('token') == ''){
      return redirect(base_url('dashboard/login'));
    }else{
      if($this->session->userdata('isLoginAdmin') == true){
        $data = [
          'username' => $this->session->userdata('username'),
          'title' => 'Dashboard | Menu'
        ];
        $url = base_url('/api/main/menu');
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer '.$this->session->userdata('token')
          )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        // Send the request
        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);

        $getMenu = json_decode($result,true);
        $menu['datamenu'] = $getMenu['data'];
        
        $this->load->view('layout/header',$data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar',$data);
        $this->load->view('menu',$menu);
        $this->load->view('layout/footer');
      }
    }
  }

  public function delete_menu($id){
    if($this->session->userdata('token') == ''){
      return redirect(base_url('dashboard/login'));
    }else{
      if($this->session->userdata('isLoginAdmin') == true){
        $url = base_url('/api/main/menu/id/'.$id);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer '.$this->session->userdata('token')
          )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        // Send the request
        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);
        $deleteUser = json_decode($result,true);
        if($deleteUser['status'] == 200){
          echo ("<script LANGUAGE='JavaScript'>
          window.alert('Menu deleted!');
          window.location.href='".base_url('dashboard/menu')."';
          </script>");
        }else{
          echo ("<script LANGUAGE='JavaScript'>
          window.alert('Failed to delete');
          window.location.href='".base_url('dashboard/menu')."';
          </script>");
        }

      }
    }
    
  }

  public function create_menu(){
    if($this->session->userdata('token') == ''){
      return redirect(base_url('dashboard/login'));
    }else{
      if($this->session->userdata('isLoginAdmin') == true){
        $data = [
          'username' => $this->session->userdata('username'),
          'title' => 'Dashboard | Menu'
        ];
        $dataCreate = [
          'nama'=> $this->input->post('nama'),
          'harga'=> $this->input->post('harga'),
          'kategori'=> $this->input->post('kategori')
        ];

        $config = array(
          'upload_path' => "./uploads/",             //path for upload
          'allowed_types' => "gif|jpg|png|jpeg",   //restrict extension
          'max_size' => '10000',
          'max_width' => '10242',
          'max_height' => '768323',
          'file_name' => 'menu_'.date('ymdhis')
          );

          $this->load->library('upload',$config);

          if($this->upload->do_upload('image')) 
          {

              $data = array('upload_data' => $this->upload->data());
              $path = $config['upload_path'].'/'.$data['upload_data']['orig_name'];
              $filename = $data['upload_data']['orig_name'];
              $dataCreate['image'] = $filename;

              $url = base_url('/api/main/menu');
              $curl = curl_init($url);
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
          
              curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$this->session->userdata('token')
                )
              );
      
              /* Set JSON data to POST */
              curl_setopt($curl, CURLOPT_POSTFIELDS, $dataCreate);
      
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
              // Send the request
              $result = curl_exec($curl);
              // Free up the resources $curl is using
              curl_close($curl);
      
              $getMenu = json_decode($result,true);
              $menu['datamenu'] = $getMenu['data'];
      
              
              echo ("<script LANGUAGE='JavaScript'>
              window.alert('Berhasil di simpan');
              window.location.href='".base_url('dashboard/menu')."';
              </script>");
              return;

          }
      }
    }
  }

  public function edit_menu($id){
    if($this->session->userdata('token') == ''){
      return redirect(base_url('dashboard/login'));
    }else{
      if($this->session->userdata('isLoginAdmin') == true){
        $data = [
          'username' => $this->session->userdata('username'),
          'title' => 'Dashboard | Menu'
        ];
        $url = base_url('/api/main/menu/id/'.$id);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer '.$this->session->userdata('token')
          )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        // Send the request
        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);

        $getMenu = json_decode($result,true);
        $menu['datamenu'] = $getMenu['data'];



        $this->load->view('layout/header',$data);
        $this->load->view('layout/sidebar');
        $this->load->view('layout/navbar',$data);
        $this->load->view('edit_menu',$menu);
        $this->load->view('layout/footer');
      }
    }
  }


  public function proses_edit_menu($id){
    if($this->session->userdata('token') == ''){
      return redirect(base_url('dashboard/login'));
    }else{
      if($this->session->userdata('isLoginAdmin') == true){
        $data = [
          'username' => $this->session->userdata('username'),
          'title' => 'Dashboard | Menu'
        ];
        $dataCreate = [
          'nama'=> $this->input->post('nama'),
          'harga'=> $this->input->post('harga'),
          'kategori'=> $this->input->post('kategori')
        ];

        $url = base_url('/api/main/menu/id/'.$id);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer '.$this->session->userdata('token')
          )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        // Send the request
        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);

        $getMenu = json_decode($result,true);
        $datamenu = $getMenu['data'];


        $config = array(
          'upload_path' => "./uploads/",             //path for upload
          'allowed_types' => "gif|jpg|png|jpeg",   //restrict extension
          'max_size' => '10000',
          'max_width' => '10242',
          'max_height' => '768323',
          'file_name' => 'menu_'.date('ymdhis')
          );

          $this->load->library('upload',$config);

          if($this->upload->do_upload('image')) 
          {
              $data = array('upload_data' => $this->upload->data());
              $path = $config['upload_path'].'/'.$data['upload_data']['orig_name'];
              $filename = $data['upload_data']['orig_name'];
              $dataCreate['image'] = $filename;
              $dataPut= json_encode($dataCreate);


              // var_dump($dataCreate);die();
              $url = base_url('/api/main/menu/id/'.$id);
              $curl = curl_init($url);
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
          
              curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$this->session->userdata('token'),
                'Content-Type:application/json'
                )
              );

              /* Set JSON data to POST */
              curl_setopt($curl, CURLOPT_POSTFIELDS, $dataPut);
      
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
              // Send the request
              $result = curl_exec($curl);
              // Free up the resources $curl is using
              curl_close($curl);
      
              $getMenu = json_decode($result,true);
              $menu['datamenu'] = $getMenu['status'];
      
              echo ("<script LANGUAGE='JavaScript'>
              window.alert('Berhasil di edit');
              window.location.href='".base_url('dashboard/menu')."';
              </script>");
              return;

          }else{
            
              $dataCreate['image'] = $datamenu[0]['image'];

              $dataPut= json_encode($dataCreate);
              $url = base_url('/api/main/menu/id/'.$id);
              $curl = curl_init($url);
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
          
              curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$this->session->userdata('token'),
                'Content-Type:application/json'
                )
              );
      
              /* Set JSON data to POST */
              curl_setopt($curl, CURLOPT_POSTFIELDS, $dataPut);
      
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
              // Send the request
              $result = curl_exec($curl);
              // Free up the resources $curl is using
              curl_close($curl);
      
              $getMenu = json_decode($result,true);
              $menu['datamenu'] = $getMenu['status'];

              echo ("<script LANGUAGE='JavaScript'>
              window.alert('Berhasil di edit');
              window.location.href='".base_url('dashboard/menu')."';
              </script>");
              return;
          }
      }
    }
  }



  public function create_cart($id){
    if($this->session->userdata('token') == ''){
      return redirect(base_url('dashboard/login'));
    }else{
      if($this->session->userdata('isLoginAdmin') == true){
        $data = [
          'username' => $this->session->userdata('username'),
          'title' => 'Dashboard | Cart'
        ];

        $url = base_url('/api/main/menu/id/'.$id);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer '.$this->session->userdata('token')
          )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        // Send the request
        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);

        $getMenu = json_decode($result,true);
        $menu = $getMenu['data'];

        $dataCreate = [
          'idmenu' => $id,
          'namamenu' => $menu[0]['nama'],
          'user' => $this->session->userdata('username'),
          'harga'  => $menu[0]['harga'],
          'qty'  => 1,
          'subtotal'  => $menu[0]['harga'] * 1,
        ];

        $url = base_url('/api/main/cart');
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer '.$this->session->userdata('token')
          )
        );

        /* Set JSON data to POST */
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dataCreate);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        // Send the request
        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);

        $getMenu = json_decode($result,true);
        $cart['datamenu'] = $getMenu['data'];

        
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Berhasil di tambahkan');
        window.location.href='".base_url('android')."';
        </script>");
        return;

      } 
    }
  }

  public function cart(){
    if($this->session->userdata('token') == ''){
      return redirect(base_url('android/login'));
    }else{
      if($this->session->userdata('isLoginAdmin') == true){
        $data = [
          'username' => $this->session->userdata('username'),
          'title' => 'Dashboard | Cart'
        ];
        $url = base_url('/api/main/cart/'.$this->session->userdata('username'));
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer '.$this->session->userdata('token')
          )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        // Send the request
        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);

        $getMenu = json_decode($result,true);
        $menu['datamenu'] = $getMenu['data'];
        if(isset($getMenu['total'])){
          $menu['datatotal'] = $getMenu['total'];
          $this->session->set_userdata('total', $menu['datatotal']);
        }else{
          $menu['datatotal'] = 0;
        }

        $this->load->view('layout/header',$data);
        $this->load->view('layout/sidebarandroid');
        $this->load->view('layout/navbarandroid',$data);
        $this->load->view('keranjang',$menu);
        $this->load->view('layout/footer');
      }
    }
  }


  public function delete_cart($id){
    if($this->session->userdata('token') == ''){
      return redirect(base_url('android/login'));
    }else{
      if($this->session->userdata('isLoginAdmin') == true){
        $url = base_url('/api/main/cart/id/'.$id);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer '.$this->session->userdata('token')
          )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        // Send the request
        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);
        $deleteUser = json_decode($result,true);
        if($deleteUser['status'] == 200){
          echo ("<script LANGUAGE='JavaScript'>
          window.alert('cart deleted!');
          window.location.href='".base_url('android/cart')."';
          </script>");
        }else{
          echo ("<script LANGUAGE='JavaScript'>
          window.alert('Failed to delete');
          window.location.href='".base_url('android/cart')."';
          </script>");
        }

      }
    }
  }

  public function confirm(){
    if($this->session->userdata('token') == ''){
      return redirect(base_url('android/login'));
    }else{

      if($this->session->userdata('isLoginAdmin') == true){
        $data = [
          'username' => $this->session->userdata('username'),
          'title' => 'Dashboard | Cart'
        ];
        $url = base_url('/api/main/cart/'.$this->session->userdata('username'));
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer '.$this->session->userdata('token')
          )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        // Send the request
        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);

        $getMenu = json_decode($result,true);
        $menu['datamenu'] = $getMenu['data'];

        
        for ($j=0; $j < count($menu['datamenu']) ; $j++) { 
          # code...
          
          // var_dump($menu['datamenu'][$j]['subtotal']);die();
          if($this->input->post('kota') === 'JABODETABEK'){
            $ongkir = 8000;
          }else{
            $ongkir = 15000;
          }
          
          $dataCreate = [
            'tanggal' => date("Y-m-d"),     
            'user' => $this->session->userdata('username'),
            'total' => $this->session->userdata('total'),
            'item'  => json_encode($menu['datamenu']),
            'nama'=> $menu['datamenu'][$j]['namamenu'],
            'subtotal'=> $menu['datamenu'][$j]['subtotal'],
            'qty'=> $menu['datamenu'][$j]['qty'],
            'status'=>'Pesanan diproses',
            'alamat'=> $this->input->post('alamat'),
            'notes'=> $this->input->post('notes'),
            'kota'=> $this->input->post('kota'),
            'ongkir'=> $ongkir

          ];


          $url = base_url('/api/main/pesanan');
          $curl = curl_init($url);
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
      
          curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.$this->session->userdata('token')
            )
          );
  
          /* Set JSON data to POST */
          curl_setopt($curl, CURLOPT_POSTFIELDS, $dataCreate);
  
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
          // Send the request
          $result = curl_exec($curl);
          // Free up the resources $curl is using
          curl_close($curl);
          
          $getMenu = json_decode($result,true);
          // var_dump($result);die();

          $cart['datamenu'] = $getMenu['data'];
  
          for ($i=0; $i < count($menu['datamenu']) ; $i++) { 
            # code...
            $menu['datamenu'][$i]['id'];
            $this->db->query("DELETE FROM keranjang WHERE id=".$menu['datamenu'][$i]['id']."");
          }
  
        }

     
        
        echo ("<script LANGUAGE='JavaScript'>
        window.alert('Berhasil di pesan, tunggu sebentar ya pesanan kamu sedang kami siapkan');
        window.location.href='".base_url('android')."';
        </script>");
        return;
      }
    }
  }


  public function pesanan(){
    if($this->session->userdata('token') == ''){
      return redirect(base_url('android/login'));
    }else{
      if($this->session->userdata('isLoginAdmin') == true){
        $data = [
          'username' => $this->session->userdata('username'),
          'title' => 'Dashboard | Pesanan'
        ];
        $url = base_url('/api/main/pesananpribadi/'.$this->session->userdata('username'));
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer '.$this->session->userdata('token')
          )
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        // Send the request
        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);

        $getMenu = json_decode($result,true);
        $menu['datamenu'] = $getMenu['data'];
        if(isset($getMenu['total'])){
          $menu['datatotal'] = $getMenu['total'];
          $this->session->set_userdata('total', $menu['datatotal']);
        }else{
          $menu['datatotal'] = 0;
        }
        
        $this->load->view('layout/header',$data);
        $this->load->view('layout/sidebarandroid');
        $this->load->view('layout/navbarandroid',$data);
        $this->load->view('pesanan',$menu);
        $this->load->view('layout/footer');
      }
    }
  }

}
