import { type NextRequest, NextResponse } from "next/server"

// Mock user data - in production, this would come from your database
const users = [
  {
    id: 1,
    email: "john.doe@example.com",
    firstName: "John",
    lastName: "Doe",
    bloodType: "A+",
    phone: "+63 912 345 6789",
    location: {
      address: "123 Main St",
      city: "Makati City",
      province: "Metro Manila",
      district: "District 1",
      postalCode: "1200",
    },
    isDonor: true,
    lastDonation: "2024-01-15",
    totalDonations: 5,
    createdAt: "2024-01-01",
  },
]

export async function GET() {
  return NextResponse.json({ users })
}

export async function POST(request: NextRequest) {
  try {
    const body = await request.json()

    const newUser = {
      id: users.length + 1,
      ...body,
      createdAt: new Date().toISOString(),
      totalDonations: 0,
    }

    users.push(newUser)

    return NextResponse.json(
      {
        message: "User created successfully",
        user: newUser,
      },
      { status: 201 },
    )
  } catch (error) {
    return NextResponse.json(
      {
        error: "Failed to create user",
      },
      { status: 400 },
    )
  }
}
