import { Pie, PieChart, Cell } from "recharts";
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import { ChartContainer, ChartConfig } from "@/components/ui/chart";

interface AffirmanceRatePieProps {
  data: { outcome: string; total: number }[];
  month: string | null;
}

const colors = {
  Affirmed: "rgba(0, 51, 102, 0.9)",     // Navy Blue
  Reversed: "rgba(111, 202, 193, 0.9)",    // Turquoise (matched cyan)
  Dismissed: "rgba(100, 149, 237, 0.9)",  // Cornflower Blue
};


export function AppealsAffirmanceRatePie({ data, month }: AffirmanceRatePieProps) {
  const total = data.reduce((acc, cur) => acc + cur.total, 0);

  const chartData = data.map(({ outcome, total }) => ({
    name: outcome,
    value: total,
    fill: colors[outcome as keyof typeof colors] ?? colors.Dismissed,
  }));

  const chartConfig: ChartConfig = {
    value: {
      label: "Decisions",
    },
    ...chartData.reduce((acc, { name, fill }) => {
      acc[name] = { label: name, color: fill };
      return acc;
    }, {} as any),
  };

  return (
   <Card className="flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg">
      <CardHeader className="items-center pb-0">
        <CardTitle>COURT OF APPEALS AFFIRMANCE - RATE</CardTitle>
        <CardDescription>{month ?? "No data available"}</CardDescription>
      </CardHeader>
      <CardContent className="flex-1 pb-0">
        {chartData.length > 0 ? (
          <ChartContainer config={chartConfig} className="mx-auto max-h-[400px]">
            <div className="flex items-center justify-center gap-6">
              <PieChart width={400} height={360}>
                <Pie
                  data={chartData}
                  dataKey="value"
                  nameKey="name"
                  cx="50%"
                  cy="50%"
                  outerRadius={140}
                  label={({
                    cx,
                    cy,
                    midAngle,
                    innerRadius,
                    outerRadius,
                    percent,
                  }) => {
                    const RADIAN = Math.PI / 180;
                    const radius = innerRadius + (outerRadius - innerRadius) * 0.6;
                    const x = cx + radius * Math.cos(-midAngle * RADIAN);
                    const y = cy + radius * Math.sin(-midAngle * RADIAN);

                    return (
                      <text
                        x={x}
                        y={y}
                        fill="#fff"
                        textAnchor="middle"
                        dominantBaseline="central"
                        fontWeight="700"
                        fontSize={24}
                        style={{ userSelect: "none" }}
                      >
                        {`${(percent * 100).toFixed(1)}%`}
                      </text>
                    );
                  }}
                  labelLine={false}
                >
                  {chartData.map((entry) => (
                    <Cell
                      key={entry.name}
                      fill={entry.fill}
                      stroke="#fff"
                      strokeWidth={3}
                    />
                  ))}
                </Pie>
              </PieChart>

              <div className="flex flex-col gap-1">
                {chartData.map(({ name, fill }) => (
                  <div key={name} className="flex items-center gap-2">
                    <div
                      className="w-4 h-4 rounded-sm"
                      style={{ backgroundColor: fill }}
                    />
                    <span className="font-semibold text-sm text-black dark:text-white">
                      {name}
                    </span>
                  </div>
                ))}
              </div>
            </div>
          </ChartContainer>
        ) : (
          <div className="text-sm text-center text-gray-500">
            No affirmance data found.
          </div>
        )}
      </CardContent>
    </Card>
  );
}