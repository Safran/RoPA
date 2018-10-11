<?php

namespace App\Console\Commands;

use App\Http\Repositories\StatementRepository;
use App\Models\User;
use App\Notifications\WarnUserAboutInprogressStatements;
use Illuminate\Console\Command;

/**
 * Class StatementsMonitorCommand
 *
 * @package App\Console\Commands
 */
class StatementsMonitorCommand extends Command
{
    protected $signature = 'statements:monitor';

    protected $description = 'Monitor all inprogress monitor and warn users when needed';

    protected $repository;


	/**
	 * StatementsMonitorCommand constructor.
	 *
	 * @param StatementRepository $repository
	 */
    public function __construct(StatementRepository $repository)
    {
    	$this->repository = $repository;
        parent::__construct();
    }


	/**
	 *
	 */
	public function handle()
	{
		$inprogress = $this->repository->getInprogressQuery()->get();

		$towarn = collect();
		// Collect all users to be warned and foreach one about which statements
		foreach($inprogress as $statement)
		{
			if(!$towarn->has($statement->owner->id))
			{
				$towarn[$statement->owner->id] = collect();
			}
			$towarn[$statement->owner->id][] = $statement->id;
			if(!$towarn->has($statement->author->id))
			{
				$towarn[$statement->author->id] = collect();
			}
			$towarn[$statement->author->id][] = $statement->id;
		}

		foreach($towarn as $user_id => $statements)
		{
			try {
				$user = User::findOrFail($user_id);
				$user->notify(new WarnUserAboutInprogressStatements($statements));
			} catch(\Exception $e) {
				dd($e);

			}
		}
	}
}
