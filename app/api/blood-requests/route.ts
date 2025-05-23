import { type NextRequest, NextResponse } from "next/server"

// Mock blood requests data
const bloodRequests = [
  {
    id: 1,
    bloodType: "A+",
    urgency: "urgent",
    location: "Philippine General Hospital, Manila",
    requesterName: "Dr. Maria Santos",
    contactPhone: "+63 2 8554 8400",
    unitsNeeded: 2,
    description: "Emergency surgery patient needs A+ blood",
    status: "active",
    createdAt: "2024-01-20T10:30:00Z",
    expiresAt: "2024-01-21T10:30:00Z",
  },
  {
    id: 2,
    bloodType: "O-",
    urgency: "critical",
    location: "St. Luke's Medical Center, Quezon City",
    requesterName: "Dr. Juan Dela Cruz",
    contactPhone: "+63 2 8723 0101",
    unitsNeeded: 3,
    description: "Critical patient in ICU requires O- blood immediately",
    status: "active",
    createdAt: "2024-01-20T14:15:00Z",
    expiresAt: "2024-01-20T18:15:00Z",
  },
]

export async function GET() {
  return NextResponse.json({ requests: bloodRequests })
}

export async function POST(request: NextRequest) {
  try {
    const body = await request.json()

    const newRequest = {
      id: bloodRequests.length + 1,
      ...body,
      status: "active",
      createdAt: new Date().toISOString(),
      expiresAt: new Date(Date.now() + 24 * 60 * 60 * 1000).toISOString(), // 24 hours from now
    }

    bloodRequests.push(newRequest)

    return NextResponse.json(
      {
        message: "Blood request created successfully",
        request: newRequest,
      },
      { status: 201 },
    )
  } catch (error) {
    return NextResponse.json(
      {
        error: "Failed to create blood request",
      },
      { status: 400 },
    )
  }
}
