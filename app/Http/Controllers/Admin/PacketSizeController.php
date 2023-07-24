<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PacketSize;
use Illuminate\Http\Request;

class PacketSizeController extends Controller
{
    public function index(){
        $packetSizeAll= PacketSize::paginate(10);
        return view('dabri.pages.packet_size.packet_size',['packetSize'=>$packetSizeAll]);
    }
    public function createView(){
        return view('dabri.pages.packet_size.packet_size_create');
    }
    public function createData(Request $req ){
        $samePacketSize=PacketSize::where('packet_size',$req->post('packet_size'))->get();
       if(isset($samePacketSize[0])){
            $req->session()->flash('errorMessage','This packet Size is already created');
            return redirect('admin/packet-size');
       }else{
            $validate=$req->validate([
                'packet_size' => 'required',
            ]);
            $packetSize=new PacketSize;
                $packetSize->packet_size=$req->packet_size;
                $packetSize->save();
                $req->session()->flash('success','New packet Size Added');
                return redirect('admin/packet-size');
       }
    }

    public function editView($id){
        $packetSize=PacketSize::find($id);
        return view('dabri.pages.packet_size.edit_packet_size',['packetSize'=> $packetSize]);
    }

    public function editData(Request $req,$id){
        $packetSize=PacketSize::find($id);
        $validate=$req->validate([
            'packet_size' => 'required',
        ]);
        $packetSize->packet_size=$req->packet_size;
        $packetSize->save();
        $req->session()->flash('success','Edit Packet Type Successfully');
        return redirect('admin/packet-size');
    }

    public function destroy($id)
    {
        PacketSize::destroy($id);
        return redirect('admin/packet-size');

    }
}
