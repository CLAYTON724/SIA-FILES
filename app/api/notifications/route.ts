import { type NextRequest, NextResponse } from "next/server"

// Mock notifications data
const notifications = [
  {
    id: 1,
    userId: 1,
    type: "blood_request",
    title: "Urgent Blood Request Near You",
    message: "A+ blood needed at Philippine General Hospital - 2.5 km away",
    isRead: false,
    createdAt: "2024-01-20T15:30:00Z",
    data: {
      requestId: 1,
      bloodType: "A+",
      location: "Philippine General Hospital",
    },
  },
  {
    id: 2,
    userId: 1,
    type: "donation_reminder",
    title: "Donation Reminder",
    message: "You're eligible to donate blood again. Your last donation was 3 months ago.",
    isRead: false,
    createdAt: "2024-01-20T09:00:00Z",
    data: {},
  },
  {
    id: 3,
    userId: 1,
    type: "thank_you",
    title: "Thank You for Your Donation!",
    message: "Your blood donation helped save a life. Thank you for being a hero!",
    isRead: true,
    createdAt: "2024-01-19T16:45:00Z",
    data: {
      donationId: 123,
    },
  },
]

export async function GET(request: NextRequest) {
  const { searchParams } = new URL(request.url)
  const userId = searchParams.get("userId")

  if (userId) {
    const userNotifications = notifications.filter((n) => n.userId === Number.parseInt(userId))
    return NextResponse.json({ notifications: userNotifications })
  }

  return NextResponse.json({ notifications })
}

export async function POST(request: NextRequest) {
  try {
    const body = await request.json()

    const newNotification = {
      id: notifications.length + 1,
      ...body,
      isRead: false,
      createdAt: new Date().toISOString(),
    }

    notifications.push(newNotification)

    return NextResponse.json(
      {
        message: "Notification created successfully",
        notification: newNotification,
      },
      { status: 201 },
    )
  } catch (error) {
    return NextResponse.json(
      {
        error: "Failed to create notification",
      },
      { status: 400 },
    )
  }
}

export async function PATCH(request: NextRequest) {
  try {
    const body = await request.json()
    const { id, isRead } = body

    const notification = notifications.find((n) => n.id === id)
    if (!notification) {
      return NextResponse.json({ error: "Notification not found" }, { status: 404 })
    }

    notification.isRead = isRead

    return NextResponse.json({
      message: "Notification updated successfully",
      notification,
    })
  } catch (error) {
    return NextResponse.json(
      {
        error: "Failed to update notification",
      },
      { status: 400 },
    )
  }
}
