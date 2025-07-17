"use client"

import {
  Bar,
  BarChart,
  CartesianGrid,
  Cell,
  LabelList,
  XAxis,
  YAxis,
  ResponsiveContainer,
} from "recharts"

import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"

import {
  ChartConfig,
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
} from "@/components/ui/chart"

interface ChartBarHorizontalProps {
  data: {
    region: string
    value: number
  }[]
}

const chartConfig = {
  value: {
    label: "Count",
    color: "var(--chart-1)",
  },
  label: {
    color: "var(--background)",
  },
} satisfies ChartConfig

export function ChartBarHorizontal({ data }: ChartBarHorizontalProps) {
  const maxValue = Math.max(...data.map((d) => d.value), 0)
  const domainMax = maxValue > 0 ? Math.ceil(maxValue * 1.1) : 10 
  if (!data.length) {
    return (
      <Card className="flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg min-h-[750px] justify-center items-center text-white text-lg">
        Loading chart data...
      </Card>
    )
  }

  return (
    <Card className="flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg min-h-[315px]">
      <CardHeader>
        <CardTitle>RAB Cases Filed Distribution</CardTitle>
        <CardDescription>{new Date().getFullYear()}</CardDescription>
      </CardHeader>
      <CardContent className="overflow-x-auto min-h-[240px]">
        <ChartContainer config={chartConfig}>
          <ResponsiveContainer width="100%" height={240}>
            <BarChart
              data={data}
              layout="vertical"
              margin={{ left: 60, right: 30 }}
              barCategoryGap={12}
            >
              <defs>
                <linearGradient id="regionGradient" x1="0" y1="0" x2="1" y2="0">
                  <stop offset="0%" stopColor="#25ee9d" />
                  <stop offset="50%" stopColor="#1cd7b5" />
                  <stop offset="100%" stopColor="#07b0e8" />
                </linearGradient>
              </defs>

              <CartesianGrid horizontal={false} />
              <YAxis type="category" dataKey="region" hide />
              <XAxis type="number" domain={[0, domainMax]} hide />

              <ChartTooltip
                cursor={false}
                content={<ChartTooltipContent indicator="line" />}
              />

              <Bar
                dataKey="value"
                radius={4}
                barSize={36}
                stroke="#2caa8f"
                strokeWidth={1.5}
              >
                {data.map((_, index) => (
                  <Cell key={`cell-${index}`} fill="url(#regionGradient)" />
                ))}

                <LabelList
                  dataKey="region"
                  position="left"
                  offset={8}
                  fill="white"
                  fontSize={12}
                />

                <LabelList
                  dataKey="value"
                  position="right"
                  offset={10}
                  fill="white"
                  fontSize={12}
                  formatter={(value) =>
                    typeof value === "number" && value > 0 ? value : ""
                  }
                />
              </Bar>
            </BarChart>
          </ResponsiveContainer>
        </ChartContainer>
      </CardContent>
    </Card>
  )
}
