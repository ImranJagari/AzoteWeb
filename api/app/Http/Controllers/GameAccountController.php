<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Exceptions\GenericException;

use App\User;
use App\Account;

use Validator;
use Auth;

class GameAccountController extends Controller
{
    const TICKET_LENGTH = 32;

    private function isAccountOwnedByMe($server, $accountId)
    {
        return Account::on($server . '_auth')->where('Id', $accountId)->where('Email', Auth::user()->email)->first();
    }

    private function isServerExist($server)
    {
        $server_rule = [
            'server' => 'required|in:' . implode(',', config('dofus.servers')),
        ];

        $validator = Validator::make(['server' => $server], $server_rule);

        if ($validator->fails())
        {
            return false;
        }

        return true;
    }

    public function create()
    {
        return view('gameaccount/create');
    }

    public function store(Request $request)
    {
        if (!$this->isServerExist($request->input('server')))
        {
            return redirect()->back()->withErrors(['server' => 'Le serveur sélectionner est invalide.'])->withInput();
        }

        $database = $request->input('server') . '_auth';

        $rules = Account::$rules['register'];
        $rules['login']    = str_replace('{DB}', $database, $rules['login']);
        $rules['nickname'] = str_replace('{DB}', $database, $rules['nickname']);

        $verifier = app()->make('validation.presence');
        $verifier->setConnection($database);
        $validator = Validator::make($request->all(), $rules);
        $validator->setPresenceVerifier($verifier);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $account = new Account;
        $account->changeConnection($database);
        $account->Login           = $request->input('login');
        $account->PasswordHash    = md5($request->input('password'));
        $account->Nickname        = $request->input('nickname');
        $account->UserGroupId     = 1;
        $account->Ticket          = strtoupper(str_random(self::TICKET_LENGTH));
        $account->SecretQuestion  = 'Code secret disponible sur le site';
        $account->SecretAnswer    = sprintf('%04d', rand(0000, 9999));
        $account->Lang            = 'fr';
        $account->Email           = Auth::user()->email;
        $account->CreationDate    = date('Y-m-d H:i:s');
        $account->Tokens          = 0;
        $account->NewTokens       = 0;
        $account->SubscriptionEnd = '2016-01-01 00:00:00';
        $account->IsJailed        = false;
        $account->IsBanned        = false;
        $account->server          = $request->input('server');
        $account->save();

        $request->session()->flash('notify', ['type' => 'success', 'message' => "Vous pouvez dés à présent jouer avec le nouveau compte de jeu !"]);

        // TODO: create game account view
        //return redirect()->route('gameaccount.view', [$account->server, $account->Id]);
        return redirect()->route('profile');
    }

    public function view($server, $accountId)
    {
        if (!$this->isServerExist($server))
        {
            throw new GenericException('invalid_server', $server);
        }

        if (!$this->isAccountOwnedByMe($server, $accountId))
        {
            throw new GenericException('not_account_owner');
        }

        // TMP
        request()->session()->flash('notify', ['type' => 'info', 'message' => "Modification des comptes de jeu prochainement !"]);
        return redirect()->route('profile');
        // END

        $account = Account::on($server . '_auth')->where('Id', $accountId)->first();
        $account->server = $server;

        dd($account->Login);

        return view('gameaccount/veiw', ['account' => $account]);
    }

    public function edit($server, $accountId)
    {
        if (!$this->isServerExist($server))
        {
            throw new GenericException('invalid_server', $server);
        }

        if (!$this->isAccountOwnedByMe($server, $accountId))
        {
            throw new GenericException('not_account_owner');
        }
    }

    public function update(Request $request, $server, $accountId)
    {
        if (!$this->isServerExist($server))
        {
            throw new GenericException('invalid_server', $server);
        }

        if (!$this->isAccountOwnedByMe($server, $accountId))
        {
            throw new GenericException('not_account_owner');
        }
    }
}