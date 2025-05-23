"use client"

import { useState } from "react"
import { ChevronDown, ChevronUp } from "lucide-react"

import { Button } from "@/components/ui/button"
import { Checkbox } from "@/components/ui/checkbox"
import { Label } from "@/components/ui/label"
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Slider } from "@/components/ui/slider"

export function SearchFilters() {
  const [expanded, setExpanded] = useState(false)

  return (
    <div className="rounded-lg border p-4">
      <div className="flex items-center justify-between">
        <h3 className="font-medium">Filters</h3>
        <Button variant="ghost" size="sm" onClick={() => setExpanded(!expanded)}>
          {expanded ? (
            <>
              <ChevronUp className="mr-1 h-4 w-4" />
              Hide
            </>
          ) : (
            <>
              <ChevronDown className="mr-1 h-4 w-4" />
              Show
            </>
          )}
        </Button>
      </div>

      {expanded && (
        <div className="mt-4 grid gap-4 md:grid-cols-2">
          <div className="space-y-2">
            <Label>Blood Type</Label>
            <div className="grid grid-cols-4 gap-2">
              {["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"].map((type) => (
                <div key={type} className="flex items-center space-x-2">
                  <Checkbox id={`blood-type-${type}`} />
                  <Label htmlFor={`blood-type-${type}`} className="text-sm font-normal">
                    {type}
                  </Label>
                </div>
              ))}
            </div>
          </div>

          <div className="space-y-2">
            <Label>Location</Label>
            <Select>
              <SelectTrigger>
                <SelectValue placeholder="Select location" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="current">Current location</SelectItem>
                <SelectItem value="manila">Manila</SelectItem>
                <SelectItem value="quezon">Quezon City</SelectItem>
                <SelectItem value="makati">Makati</SelectItem>
                <SelectItem value="cebu">Cebu City</SelectItem>
                <SelectItem value="davao">Davao City</SelectItem>
              </SelectContent>
            </Select>
          </div>

          <div className="space-y-2">
            <Label>Distance (km)</Label>
            <div className="px-2">
              <Slider defaultValue={[10]} max={50} step={1} />
              <div className="mt-1 flex justify-between text-xs text-gray-500">
                <span>0 km</span>
                <span>25 km</span>
                <span>50 km</span>
              </div>
            </div>
          </div>

          <div className="space-y-2">
            <Label>Availability</Label>
            <RadioGroup defaultValue="all">
              <div className="flex items-center space-x-2">
                <RadioGroupItem value="all" id="availability-all" />
                <Label htmlFor="availability-all" className="text-sm font-normal">
                  All
                </Label>
              </div>
              <div className="flex items-center space-x-2">
                <RadioGroupItem value="available" id="availability-available" />
                <Label htmlFor="availability-available" className="text-sm font-normal">
                  Available now
                </Label>
              </div>
              <div className="flex items-center space-x-2">
                <RadioGroupItem value="scheduled" id="availability-scheduled" />
                <Label htmlFor="availability-scheduled" className="text-sm font-normal">
                  Scheduled availability
                </Label>
              </div>
            </RadioGroup>
          </div>

          <div className="md:col-span-2 flex justify-end gap-2">
            <Button variant="outline" size="sm">
              Reset
            </Button>
            <Button size="sm" className="bg-red-600 hover:bg-red-700">
              Apply Filters
            </Button>
          </div>
        </div>
      )}
    </div>
  )
}
