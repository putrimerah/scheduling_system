# Scheduling system

I design the scheduling system inspired by calendly, the purpose is to record the event schedule. For this project I focused on main feature which is event booking **outisde user creation and authentication process**

For high level design, you can visit [this link](https://docs.google.com/document/d/10W4FdKZWGCtO5lEhkNOwyhoSs5jRaYbORL4GTW513DE/edit?usp=sharing)

## Requirements
### Create an event

User only able to create an event no less than this month

1. Add a title
2. Add available day
3. Add a slots range
4. Add a meeting duration. For the MVP I encourage to available for 30 and 60 minutes
5. Generate a link to view available schedule

### Book a schedule

client only able to book a schedule in available time

1. Book the schedule
2. mark the date
3. mark the time
4. input full name, email and another description

### Edit schedule

Only user who able to edit this

1. Edit event name
2. Reschedule booked event

### Delete schedule

User only able to delete when the event hasn't started or has ended

1. Only user who able to delete a schedule

### View a schedule

Only client with given link who able to view the availability

1. View both available and unavailable date
2. View available time

## 🗂️ Database Schema

---

### 🧑 users

| Column       | Type     | Description              |
|--------------|----------|--------------------------|
| id           | int      | **Primary key**              |
| username     | string   | Unique username          |
| fullname     | string   | User's full name         |
| password     | string   | Hashed password          |
| created_at   | datetime | Timestamp of creation    |
| updated_at   | datetime | Timestamp of last update |

---

### 📅 events

| Column       | Type     | Description                          |
|--------------|----------|--------------------------------------|
| id           | int      | **Primary key**                          |
| event_uuid   | uuid     | Public UUID for sharing link         |
| user_id      | int      | Foreign key → users(id)              |
| name         | string   | Name of the event                    |
| event_start  | time     | Event start time (template/rule)     |
| event_end    | time     | Event end time (template/rule)       |
| duration     | int      | Duration in minutes                  |
| created_at   | datetime | Timestamp of creation                |
| updated_at   | datetime | Timestamp of last update             |

---

### 📆 event_availabilities

| Column       | Type     | Description                          |
|--------------|----------|--------------------------------------|
| id           | int      | **Primary key**                          |
| event_id     | int      | Foreign key → events(id)             |
| event_day    | string   | Day of week or date (e.g., 'Monday') |
| event_times  | JSON     | Available times (e.g., ["09:00", "13:30"]) |
| created_at   | datetime | Timestamp of creation                |

---

### 📋 event_books

| Column       | Type     | Description                          |
|--------------|----------|--------------------------------------|
| id           | int      | **Primary key**                          |
| event_id     | int      | Foreign key → events(id)             |
| event_date   | date     | **Primary Key** Date of the booked event |
| fullname     | string   | Guest full name                      |
| email        | string   | Guest email                          |
| description  | text     | Optional message/notes               |
| token        | string   | Unique token for reschedule/cancel   |
| created_at   | datetime | Timestamp of booking                 |

---

### 🔗 Relationships

- `users (1) — (M) events`
- `events (1) — (M) event_availabilities`
- `events (1) — (M) event_books`

## Add an available schedule
### Endpoint to create an event
```
users/{id}/event
Request
Method : POST
{
	"name": "J League footballer hiring",
	"event_start": "2025-06-01",
	"event_end": "2025-08-01",
	"duration": 30
}

Response 200
{
	"message": "create event success"
}
```

### Endpoint to add available time
```
users/{id}/events/{event_id}/availabilities
{
	"event_date": "2025-06-01",
	"event_time": ["10:00:00", "10:30:00"]
}

Response 200
{
	"message": "add available time success"
}
```

### Endpoint to book a schedule
```
books/{event_uuid}
{
	"event_date": "2025-01-01 10:00:00"
	"fullname": "Ricardo Kaka",
	"email": "ricardo.kaka@gmail.com",
	"description": "I am an experienced footballer"
}

Response 200
{
	"message": "booking success"
}

Response 400
{
	"message": "the event date has booked by others"
}
```

## Edit a schedule
### Edit an event
```
Desc : User only allowed to update the event name
user/{id}/events/{event_id}/books/{event_book_id}
{
	"event_name": "League 1 footballer hiring",
}
```

### Reschedule an event
user/{id}/events/{event_id}/books/{event_book_id}
```
{
	"event_date" : "2025-01-01 10:00:00"
}

Response 200
{
	"message": "booking success"
}

Response 400
{
	"message": "booking time is unavailable"
}
```

## Delete a booked event
```
user/{id}/books/{event_book_id}
Request

Response 204
```


## Veiw an available schedule
### View an available schedule
```
{
	"availability_timezone": "Asia/Jakarta",
	"days": [
		{
			"date": "2025-05-02",
			"status": "unavailable"
			"spots": []
		},
		{
			"date": "2025-05-03",
			"status": "available",
			"spots": [
				{
					"start_time": "2025-05-03T10:00:00+07:00",
					"status": "available"
				},
				{
					"start_time": "2025-05-03T10:30:00+07:00",
					"status": "unavailable"
				},
				{
					"start_time": "2025-05-03T11:00:00+07:00",
					"status": "available"
				},
			]
		}
	]
}
```