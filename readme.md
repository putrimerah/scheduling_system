Scheduling system
============================
Desc : 
make an apps similar with calendly

What is inside the scheduling system?
1. Make a schedule
2. Edit a schedule 
3. Delete a schedule

The condition
Add an available schedile
1. Calendar link requirements
1.2. Add a title
1.3. Add available day
1.4. Add a slots range
1.5. Add a meeting duration. For the MVP I encourage to available for 30 and 60 minutes
2.  Generate a link to view available schedule

Book a schedule
1. Book a scheduke
1.1. mark a date
1.2. mark a time
1.3. input full name, email and another description

Edit schedule
2. Only who user able to reschedule the event

Delete schedule
1. Only user who able to delete a schedule

View a schedule
1. View both available and unavailable date
2. View available time


High level design
# Add an available schedule
## Endpoint to make an available schedule
```
user/{{id}}/add
{
	"available_day": ["Monday", "Tuesday", "Wednesday"],
	"time_start": "09:00:00"
	"time_end": "17:00:00"
	"duration": 30
}
```
