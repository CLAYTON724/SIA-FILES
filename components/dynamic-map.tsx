"use client"

import { useEffect, useState } from "react"
import dynamic from "next/dynamic"

// Dynamically import the MapView component with no SSR
const MapViewWithNoSSR = dynamic(() => import("./map-view-client").then((mod) => mod.MapView), {
  ssr: false,
  loading: () => (
    <div className="flex h-[400px] w-full items-center justify-center rounded-lg border bg-gray-100">
      <div className="text-center">
        <div className="inline-block h-6 w-6 animate-spin rounded-full border-2 border-solid border-red-600 border-r-transparent"></div>
        <p className="mt-2 text-sm text-gray-500">Loading map...</p>
      </div>
    </div>
  ),
})

interface DynamicMapProps {
  type: "donors" | "banks"
}

export function DynamicMap({ type }: DynamicMapProps) {
  const [isMounted, setIsMounted] = useState(false)

  useEffect(() => {
    setIsMounted(true)
  }, [])

  if (!isMounted) {
    return (
      <div className="flex h-[400px] w-full items-center justify-center rounded-lg border bg-gray-100">
        <div className="text-center">
          <div className="inline-block h-6 w-6 animate-spin rounded-full border-2 border-solid border-red-600 border-r-transparent"></div>
          <p className="mt-2 text-sm text-gray-500">Loading map...</p>
        </div>
      </div>
    )
  }

  return <MapViewWithNoSSR type={type} />
}
