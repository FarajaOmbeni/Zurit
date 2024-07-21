<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;
use Auth;
use Carbon\Carbon;
Use DateTime;

class GoalController extends Controller
{
    public function showGoalData(){
        $goals = Goal::where('user_id', auth()->id())->get();
        $this->classifyGoals($goals);
    
        $totalGoals = $goals->count();
        $completedGoals = $goals->filter(function ($goal) {
            return $goal->current_amount >= $goal->goal_amount;
        })->count();
    
        $completionPercentages = $goals->map(function ($goal) {
            return ($goal->current_amount / $goal->goal_amount) * 100;
        });
    
        return view('user_goalsetting', [
            'goals' => $goals,
            'totalGoals' => $totalGoals,
            'completedGoals' => $completedGoals,
            'completionPercentages' => $completionPercentages,
        ]);
    }
    
    
    public function storeGoal(Request $request){
        $validatedData = $request->validate([
            'title' => 'required|string',
            'goal_amount'=> 'required|numeric',
            'current_amount'=> 'nullable|numeric',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
        ]);

        $validatedData['user_id'] = Auth::id();

        Goal::create($validatedData);

        return redirect('user_goalsetting')->with('success', [
            'message' => 'Goal Set Successfully!',
            'duration' => 2000,
        ]);
        
    }

    public function addcurrentamount(Request $request, $id){
        $goal = Goal::find($id);
        $addedAmount = $request->input('addedAmount');
        $goal->current_amount += $addedAmount;
        $goal->save();
    
        
        return redirect('user_goalsetting')->with([
            'success' => [
                'amount_message' => 'Successfully added amount to the goal',
                'duration' => 2000,
                'goal_id' => $id,
            ],
        ]);

    }

    public function calculateProjectedDates($goals){
        foreach ($goals as $goal) {
            // Calculate the projected completion date
            if ($goal->current_amount < $goal->goal_amount) {
                $updatedAt = new DateTime($goal->updated_at);
                $startDate = new DateTime($goal->start_date);
                $daysBetweenAdds = $updatedAt->diff($startDate)->days;
                $remainingAmount = $goal->goal_amount - $goal->current_amount;
    
                // Check if last_added_amount is not zero
                if ($goal->last_added_amount != 0) {
                    $daysToComplete = $remainingAmount / $goal->last_added_amount * $daysBetweenAdds;
                    $projectedCompleteDate = $updatedAt->modify('+' . $daysToComplete . ' days');
                    $goal->projected_attainment_date = $projectedCompleteDate->format('Y-m-d');
                } else {
                    // Handle the case when last_added_amount is zero
                    $goal->projected_attainment_date = null;
                }
            }
        }
    }
    

    public function classifyGoals($goals)
    {
        foreach ($goals as $goal) {
            $createdAt = Carbon::parse($goal->created_at);
            $deadline = Carbon::parse($goal->deadline);
            $durationInDays = $createdAt->diffInDays($deadline);

            $shortTermThreshold = 30; 
            $middleTermThreshold = 180; 

            if ($durationInDays <= $shortTermThreshold) {
                $goal->period = 'short-term';
            } elseif ($durationInDays <= $middleTermThreshold) {
                $goal->period = 'medium-term';
            } else {
                $goal->period = 'long-term';
            }

            $goal->save();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $goal = Goal::findOrFail($id);
        $goal->delete();

        return redirect()->route('user_goalsetting')->with('success', [
            'message' => 'Goal Deleted Successfully!',
            'duration' => 3000,
        ]);
    }

}
