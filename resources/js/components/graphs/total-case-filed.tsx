import { Scale } from 'lucide-react';
import { Badge } from "@/components/ui/badge"
import {
  Card,
  CardAction,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"

export function SectionCards() {
  return (
    <div className="grid grid-cols-1 gap-4 px-0 lg:px-0 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">
      <Card
        className="border border-[#2c9a93] shadow-sm @container/card"
        style={{
          background: 'radial-gradient(circle, rgba(223,246,245,0.9) 0%, rgba(120,185,181,0.9) 50%, rgba(44,154,147,0.9) 100%)',
        }}
      >
        <CardHeader className="flex items-center gap-4">
          {/* Left-side connected icon */}
          <div className="flex-shrink-0 rounded-full bg-[#04332f]/80 p-4 flex items-center justify-center">
            <Scale className="text-cyan-400 w-10 h-10" />
          </div>

          {/* Text content */}
          <div className="flex-1">
            <CardDescription className="text-[#064e45] font-semibold drop-shadow-md">
              Total RAB Cases Filed
            </CardDescription>
            <CardTitle className="text-4xl font-bold tabular-nums text-center text-[#04332f] drop-shadow-lg @[250px]/card:text-3xl">
              1,250
            </CardTitle>
          </div>

          <CardAction />
        </CardHeader>
      </Card>
    </div>
  )
}
