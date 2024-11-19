<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\UserCharacter;
use App\Models\Setting;
use App\Models\AppUser;
use App\Models\GuestUser;
use Illuminate\Http\Request;
use Validator;

class CharacterController extends Controller
{

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_type' => 'required',
            'user_id' => 'required_if:user_type,app',
            'device_id' => 'required_if:user_type,guest',
        ]);
        
        if($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        } 

        $user_type = $request->get('user_type');
        $user_id = $request->get('user_id');
        $device_id = $request->get('device_id');
        
        $characters = Character::all();

        $characters->map(function($character) use($user_type,$user_id,$device_id){

            if(!empty($character->photo)){
                $character->photo = asset('images/characters/'.$character->photo);
            }
            
            if($user_type == "app"){

                $exist = UserCharacter::where('character_id',$character->id)->where('user_id',$user_id)->first();
                if($exist){
                    $character->lock = 'no';
                }

            }else if($user_type == "guest"){

                $exist = UserCharacter::where('character_id',$character->id)->where('device_id',$device_id)->first();
                if($exist){
                    $character->lock = 'no';
                }
            }
            
            return $character;
        });
        
        $response['success'] = 'Success';
        $response['error'] = NULL;
        $response['data'] = $characters;

        return response()->json($response);
    }

    public function AddSeenUnlockCharacter(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_type' => 'required|in:app,guest',
            'user_id' => 'required_if:user_type,app',
            'device_id' => 'required_if:user_type,guest',
            'character_id' => 'required|integer',
        ]);
        
        if($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        } 

        $user_type = $request->get('user_type');
        $user_id = $request->get('user_id');
        $device_id = $request->get('device_id');
        $character_id = $request->get('character_id');

        if($user_type == "app"){

            UserCharacter::create([
                'user_id' => $user_id,
                'device_id' => '',
                'character_id' => $character_id,
            ]);

        }else if($user_type == "guest"){

            UserCharacter::create([
                'user_id' => '',
                'device_id' => $device_id,
                'character_id' => $character_id,
            ]);

        }

        $response['success'] = 'Success';
        $response['error'] = NULL;
        $response['message'] = 'Character successfully unlocked for user';

        return response()->json($response);
    }

    public function AddSeenLimitIncrease(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_type' => 'required|in:app,guest',
            'user_id' => 'required_if:user_type,app',
            'device_id' => 'required_if:user_type,guest',
        ]);
        
        if($validator->fails()) {
            return response()->json(['success'=>'Failed','error' => $validator->errors()->first()], 400);
        } 

        $user_type = $request->get('user_type');
        $user_id = $request->get('user_id');
        $device_id = $request->get('device_id');

        $setting = Setting::find(1);
        
        if($user_type == "app"){

            $user = AppUser::find($user_id);
            
            $writer_limit = $user->writer_limit + $setting->ads_writer_limit;
            $chat_limit = $user->chat_limit + $setting->ads_chat_limit;
            $image_limit = $user->image_limit + $setting->ads_image_limit;

            $user->writer_limit = $writer_limit;
            $user->chat_limit = $chat_limit;
            $user->image_limit = $image_limit;
            $user->save();

        }else if($user_type == "guest"){

            $user = GuestUser::where('device_id',$device_id)->first();
            
            $writer_limit = $user->writer_limit + $setting->ads_writer_limit;
            $chat_limit = $user->chat_limit + $setting->ads_chat_limit;
            $image_limit = $user->image_limit + $setting->ads_image_limit;

            $user->writer_limit = $writer_limit;
            $user->chat_limit = $chat_limit;
            $user->image_limit = $image_limit;
            $user->save();
        }

        $response['success'] = 'Success';
        $response['error'] = NULL;
        $response['message'] = 'Limit successfully increased for user';

        return response()->json($response);
    }
}
